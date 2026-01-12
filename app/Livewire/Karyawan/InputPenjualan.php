<?php

namespace App\Livewire\Karyawan;

use App\Models\ManjemenBarang as ManajemenBarang;
use App\Models\Penjualan;
use Livewire\Component;
use App\Models\PenjualanProduk;
use Throwable;
use Illuminate\Support\Facades\DB;

class InputPenjualan extends Component
{
    public $produkSemua;
    public $kategori = 'all';
    public $keranjang = [];
    public $uangPembeli = 0;
    public $totalHarga = 0;
    public $jumlah = [];

    public function mount()
    {
        $this->produkSemua = ManajemenBarang::all();
        // inisialisasi default jumlah = 1 untuk setiap produk agar input tidak undefined
        foreach ($this->produkSemua as $p) {
            $this->jumlah[$p->id] = 1;
        }
    }

    public function filterKategori($kat)
    {
        $this->kategori = $kat;

        if ($kat === 'all' || empty($kat)) {
            $this->produkSemua = ManajemenBarang::orderBy('id', 'desc')->get();
        } else {
            // asumsikan kolom 'kategori' menyimpan string seperti 'Buku', 'Alat Tulis'
            $this->produkSemua = ManajemenBarang::where('kategori', $kat)
                ->orderBy('id', 'desc')
                ->get();
        }

        // Pastikan default jumlah tersedia untuk produk yang baru ter-load
        foreach ($this->produkSemua as $p) {
            if (!isset($this->jumlah[$p->id])) {
                $this->jumlah[$p->id] = 1;
            }
        }
    }

    public function tambahKeKeranjang($id)
    {
        $produk = ManajemenBarang::find($id);
        if (!$produk) {
            return;
        }

        $qty = $this->jumlah[$id] ?? 1;
        $index = collect($this->keranjang)->search(fn($item) => $item['id'] === $id);

        if ($index !== false) {
            $this->keranjang[$index]['jumlah'] += $qty;
        } else {
            $this->keranjang[] = [
                'id'    => $produk->id,
                'nama'  => $produk->namaproduk,
                'harga' => $produk->harga,
                'jumlah'=> $qty,
            ];
        }

        $this->jumlah[$id] = 1; // reset input
        $this->hitungTotalHarga();
    }

    public function hapusItem($id)
    {
        $this->keranjang = collect($this->keranjang)
            ->reject(fn($item) => $item['id'] == $id)
            ->values()
            ->all();

        $this->hitungTotalHarga();
    }

    public function hitungTotalHarga()
    {
        $this->totalHarga = collect($this->keranjang)
            ->sum(fn($item) => $item['harga'] * $item['jumlah']);
    }

    public function updatedUangPembeli()
    {
        // opsional: validasi realtime
    }

    public function simpan()
{
    if (empty($this->keranjang)) {
        session()->flash('message', 'Keranjang masih kosong!');
        return;
    }

    if ($this->uangPembeli < $this->totalHarga) {
        session()->flash('message', 'Uang pembeli tidak mencukupi.');
        return;
    }

    DB::beginTransaction();

    try {
        // Buat entri penjualan dengan user_id
        $penjualan = Penjualan::create([
            'tanggal'     => now(),
            'total_harga' => $this->totalHarga,
            'user_id'     => auth()->id(),
        ]);

        // Simpan tiap item ke tabel penjualan_produk lewat model PenjualanProduk
        foreach ($this->keranjang as $item) {
            PenjualanProduk::create([
                'penjualan_id'   => $penjualan->id,
                'produk_id'      => $item['id'],
                'jumlah'         => $item['jumlah'],
                'harga_saat_itu' => $item['harga'],
            ]);
        }

        DB::commit();

        session()->flash('message', 'Penjualan berhasil disimpan.');

        // reset state
        $this->reset(['keranjang', 'uangPembeli', 'totalHarga', 'jumlah']);
        $this->kategori = 'all';
        $this->produkSemua = ManajemenBarang::all();
        foreach ($this->produkSemua as $p) {
            $this->jumlah[$p->id] = 1;
        }
    } catch (Throwable $e) {
        DB::rollBack();

        \Log::error('Error saat menyimpan penjualan: '.$e->getMessage(), [
            'exception' => $e,
            'keranjang' => $this->keranjang,
            'total'     => $this->totalHarga,
        ]);

        session()->flash('message', 'Terjadi kesalahan saat menyimpan penjualan. Silakan cek log.');
    }
}

    public function render()
    {
        return view('livewire.karyawan.input-penjualan');
    }
}
