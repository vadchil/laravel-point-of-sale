<?php

namespace Tests\Feature\Livewire;

use Tests\TestCase;
use Livewire\Livewire;
use App\Livewire\AdminDashboard;
use App\Models\Penjualan;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_sets_correct_sales_counts_and_formatted_values()
    {
        Penjualan::factory()->count(2)->create(['total_harga'=>10000, 'tanggal'=>now()]);
        Penjualan::factory()->count(3)->create(['total_harga'=>20000, 'tanggal'=>now()->subMonth()]);

        Livewire::test(AdminDashboard::class)
            ->assertSet('totalSalesCount', 5)
            ->assertSet('salesTodayFormatted', 'Rp20.000') // ubah sesuai perhitungan Anda
            ->assertSet('salesThisMonthFormatted', 'Rp20.000'); // sesuaikan
    }
}
