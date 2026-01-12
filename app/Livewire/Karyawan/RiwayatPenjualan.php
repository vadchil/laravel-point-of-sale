<?php

namespace App\Livewire\Karyawan;

use Livewire\Component;
use App\Models\Penjualan;
use Carbon\Carbon;

class RiwayatPenjualan extends Component
{
    public $tanggalAwal;
    public $tanggalAkhir;
    public $selectedPenjualan = null;

    protected $queryString = [
        'tanggalAwal'  => ['except' => ''],
        'tanggalAkhir' => ['except' => ''],
    ];

    public function mount()
    {
        // Set default tanggal hari ini jika belum ada
        $this->tanggalAwal = $this->tanggalAwal ?: now()->format('Y-m-d');
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
        $this->selectedPenjualan = Penjualan::with(['penjualanProduk.produk'])
            ->where('user_id', auth()->id())
            ->find($penjualanId);
    }

    public function closeDetail()
    {
        $this->selectedPenjualan = null;
    }

    public function render()
    {
        if (! $this->validDates()) {
            $sales = collect();
        } else {
            $start = Carbon::createFromFormat('Y-m-d', $this->tanggalAwal)->startOfDay();
            $end   = Carbon::createFromFormat('Y-m-d', $this->tanggalAkhir)->endOfDay();
            
            if ($start->gt($end)) {
                [$start, $end] = [$end, $start];
            }

            // Query penjualan hanya untuk user yang sedang login
            $sales = Penjualan::with(['penjualanProduk.produk'])
                ->where('user_id', auth()->id())
                ->whereBetween('tanggal', [$start->toDateTimeString(), $end->toDateTimeString()])
                ->orderBy('tanggal', 'desc')
                ->get();
        }

        return view('livewire.karyawan.riwayat-penjualan', [
            'sales' => $sales,
        ]);
    }
}
