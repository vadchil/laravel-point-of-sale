<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Penjualan;
use App\Models\ManjemenBarang as ManajemenBarang;

class AdminDashboard extends Component
{
    public $totalSalesCount;
    public $salesTodayFormatted;
    public $salesThisMonthFormatted;

    public function mount()
    {
        // Menghitung jumlah total penjualan (jumlah transaksi)
        $this->totalSalesCount = Penjualan::count();

        // Menghitung total penjualan hari ini dalam format IDR
        $salesToday = Penjualan::whereDate('tanggal', now()->toDateString())->sum('total_harga');
        $this->salesTodayFormatted = $this->formatToIdr($salesToday);

        // Menghitung total penjualan bulan ini dalam format IDR
        $salesThisMonth = Penjualan::whereMonth('tanggal', now()->month)->sum('total_harga');
        $this->salesThisMonthFormatted = $this->formatToIdr($salesThisMonth);
    }

    private function formatToIdr($amount)
    {
        return 'Rp' . number_format($amount, 0, ',', '.');
    }

    public function render()
    {
        return view('livewire.admin-dashboard');
    }
}
