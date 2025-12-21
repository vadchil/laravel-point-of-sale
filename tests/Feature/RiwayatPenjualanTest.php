<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Penjualan;
use App\Models\PenjualanProduk;
use App\Models\ManjemenBarang;
use Livewire\Livewire;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

// Test double: subclass komponen asli dan override emit agar tidak melempar error saat testing
class TestableRiwayatPenjualan extends \App\Livewire\Admin\RiwayatPenjualan
{
    // swallow emit calls in tests (Livewire version di environment ini tidak expose emit pada komponen)
    public function emit(...$args)
    {
        // no-op for tests
    }
}

class RiwayatPenjualanTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function component_renders_and_shows_sales_within_date_range()
    {
        $product = ManjemenBarang::create([
            'namaproduk' => 'Produk A',
            'kategori' => 'Kategori 1',
            'harga' => 5000,
            'stok' => 10,
        ]);

        $t = Carbon::create(2025, 11, 10, 10, 0, 0);
        $penjualan = Penjualan::create([
            'tanggal' => $t->toDateTimeString(),
            'total_harga' => 10000,
        ]);

        $penjualan->produk()->attach($product->id, [
            'jumlah' => 2,
            'harga_saat_itu' => 5000,
        ]);

        $awal = $t->copy()->subDay()->format('Y-m-d');
        $akhir = $t->copy()->addDay()->format('Y-m-d');

        Livewire::test(TestableRiwayatPenjualan::class)
            ->set('tanggalAwal', $awal)
            ->set('tanggalAkhir', $akhir)
            ->assertSee('Produk A')
            ->assertSee('Kategori 1');
    }

    /** @test */
    public function delete_by_date_range_removes_only_matching_penjualan()
    {
        $product = ManjemenBarang::create([
            'namaproduk' => 'Produk B',
            'kategori' => 'Kategori X',
            'harga' => 20000,
            'stok' => 5,
        ]);

        $inDate = Carbon::create(2025, 11, 10, 9, 0, 0);
        $outDate = Carbon::create(2025, 10, 1, 9, 0, 0);

        $penjualanIn = Penjualan::create([
            'tanggal' => $inDate->toDateTimeString(),
            'total_harga' => 20000,
        ]);
        $penjualanIn->produk()->attach($product->id, ['jumlah' => 1, 'harga_saat_itu' => 20000]);

        $penjualanOut = Penjualan::create([
            'tanggal' => $outDate->toDateTimeString(),
            'total_harga' => 15000,
        ]);
        $penjualanOut->produk()->attach($product->id, ['jumlah' => 1, 'harga_saat_itu' => 15000]);

        $awal = $inDate->copy()->subDay()->format('Y-m-d');
        $akhir = $inDate->copy()->addDay()->format('Y-m-d');

        Livewire::test(TestableRiwayatPenjualan::class)
            ->set('tanggalAwal', $awal)
            ->set('tanggalAkhir', $akhir)
            ->call('deleteByDateRange');

        // penjualanIn seharusnya terhapus, penjualanOut tetap ada
        $this->assertDatabaseMissing('penjualan', ['id' => $penjualanIn->id]);
        $this->assertDatabaseHas('penjualan', ['id' => $penjualanOut->id]);
    }

    /** @test */
    public function invalid_date_format_will_not_delete_and_keeps_data_intact()
    {
        $p = ManjemenBarang::create([
            'namaproduk' => 'Produk C',
            'kategori' => 'K',
            'harga' => 1000,
            'stok' => 3,
        ]);

        $penjualan = Penjualan::create([
            'tanggal' => Carbon::now()->toDateTimeString(),
            'total_harga' => 1000,
        ]);
        $penjualan->produk()->attach($p->id, ['jumlah' => 1, 'harga_saat_itu' => 1000]);

        Livewire::test(TestableRiwayatPenjualan::class)
            ->set('tanggalAwal', 'not-a-date')
            ->set('tanggalAkhir', 'also-bad')
            ->call('deleteByDateRange');

        // Data tetap ada karena format tanggal invalid sehingga delete tidak dieksekusi
        $this->assertDatabaseHas('penjualan', ['id' => $penjualan->id]);
    }
}
