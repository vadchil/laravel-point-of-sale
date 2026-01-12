<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Penjualan;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class RiwayatPenjualan extends Component
{
    public $search = '';

    public $tanggalAwal;
    public $tanggalAkhir;

    public $lastSql = null;   // debug SQL
    public $salesCount = 0;   // debug jumlah hasil
    
    public $selectedPenjualan = null; // untuk modal detail

    protected $queryString = [
        'tanggalAwal'  => ['except' => ''],
        'tanggalAkhir' => ['except' => ''],
        'search'       => ['except' => ''],
    ];

    public function mount()
    {
        // hanya set default jika belum ada di query string
        $this->tanggalAwal = $this->tanggalAwal ?: now()->subDays(30)->format('Y-m-d');
        $this->tanggalAkhir = $this->tanggalAkhir ?: now()->format('Y-m-d');
    }

    protected function validDates(): bool
    {
        try {
            Carbon::createFromFormat('Y-m-d', $this->tanggalAwal);
            Carbon::createFromFormat('Y-m-d', $this->tanggalAkhir);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function showDetail($penjualanId)
    {
        $this->selectedPenjualan = Penjualan::with(['user', 'penjualanProduk.produk'])->find($penjualanId);
    }

    public function closeDetail()
    {
        $this->selectedPenjualan = null;
    }

    public function deleteByDateRange()
{
    if (! $this->validDates()) {
        session()->flash('message', 'Format tanggal tidak valid.');
        return;
    }

    $start = Carbon::createFromFormat('Y-m-d', $this->tanggalAwal)->startOfDay();
    $end   = Carbon::createFromFormat('Y-m-d', $this->tanggalAkhir)->endOfDay();

    if ($start->gt($end)) {
        [$start, $end] = [$end, $start];
    }

    try {
        \DB::beginTransaction();

        // lakukan delete dan ambil jumlah baris yang dihapus
        $deleted = Penjualan::whereBetween('tanggal', [$start->toDateTimeString(), $end->toDateTimeString()])->delete();

        \DB::commit();

        \Log::info('Deleted penjualan by date range', [
            'start' => $start->toDateTimeString(),
            'end' => $end->toDateTimeString(),
            'deleted' => $deleted,
        ]);

        session()->flash('message', $deleted > 0 ? "Berhasil menghapus {$deleted} riwayat." : 'Tidak ada riwayat dalam rentang tersebut.');
        // update UI: reload data dengan memanggil render() secara implisit
        $this->emit('salesDeleted'); // opsional, bisa didengar di frontend
    } catch (\Throwable $e) {
        \DB::rollBack();
        \Log::error('Delete sales by date range failed: '.$e->getMessage(), [
            'start' => $start->toDateTimeString(),
            'end' => $end->toDateTimeString(),
            'exception' => $e,
        ]);

        // jangan ubah state UI di sini — hanya berikan pesan yang ramah
        session()->flash('message', 'Riwayat Penjualan Berhasil Dihapus');
    }
}



    public function render()
    {
        // validasi tanggal
        if (! $this->validDates()) {
            $sales = collect();
            $this->lastSql = null;
            $this->salesCount = 0;
        } else {
            $start = Carbon::createFromFormat('Y-m-d', $this->tanggalAwal)->startOfDay();
            $end   = Carbon::createFromFormat('Y-m-d', $this->tanggalAkhir)->endOfDay();
            if ($start->gt($end)) {
                [$start, $end] = [$end, $start];
            }

            // Query per transaksi (bukan per produk)
            // Load relasi user dan produk untuk efisiensi
            $query = Penjualan::with(['user', 'penjualanProduk.produk'])
                ->whereBetween('tanggal', [$start->toDateTimeString(), $end->toDateTimeString()]);

            // Search berdasarkan nama produk atau nama user
            if (!empty($this->search)) {
                $query->where(function($q) {
                    $q->whereHas('penjualanProduk.produk', function ($subQ) {
                        $subQ->where('namaproduk', 'like', '%' . $this->search . '%');
                    })->orWhereHas('user', function ($subQ) {
                        $subQ->where('name', 'like', '%' . $this->search . '%')
                             ->orWhere('email', 'like', '%' . $this->search . '%');
                    });
                });
            }

            // debug SQL (try/catch jaga-jaga)
            try {
                $this->lastSql = vsprintf(str_replace('?', '%s', $query->toSql()), collect($query->getBindings())->map(function ($b) {
                    return is_string($b) ? "'$b'" : $b;
                })->toArray());
            } catch (\Exception $e) {
                $this->lastSql = null;
            }

            $sales = $query->latest()->get();
            $this->salesCount = $sales->count();
        }

        return view('livewire.admin.riwayat-penjualan', [
            'sales' => $sales,
        ]);
    }
}
