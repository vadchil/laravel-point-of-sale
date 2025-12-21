<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\ManjemenBarang;
use App\Models\Penjualan;
use App\Models\PenjualanProduk;
use Livewire\Livewire;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Test-double: override dispatchBrowserEvent agar tidak melempar di test environment.
 */
class TestableInputPenjualan extends \App\Livewire\Karyawan\InputPenjualan
{
    public function dispatchBrowserEvent($event, $payload = [])
    {
        // no-op in tests
    }
}

class InputPenjualanTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function component_renders()
    {
        Livewire::test(TestableInputPenjualan::class)
            ->assertStatus(200);
    }

    /** @test */
    public function can_add_product_to_cart_and_total_is_calculated()
    {
        $product = ManjemenBarang::create([
            'namaproduk' => 'Pulpen',
            'kategori'   => 'Alat Tulis',
            'harga'      => 3000,
            'stok'       => 100,
        ]);

        $component = Livewire::test(TestableInputPenjualan::class)
            // jumlah default di mount() sudah 1, tapi set explicit untuk jaminan
            ->set("jumlah.{$product->id}", 2)
            ->call('tambahKeKeranjang', $product->id)
            ->assertSet('totalHarga', 6000)   // 2 * 3000
            ->assertSee('Pulpen');

        // Keranjang harus berisi item dengan jumlah 2
        $this->assertCount(1, $component->get('keranjang'));
        $this->assertEquals(2, $component->get('keranjang')[0]['jumlah']);
    }

    /** @test */
    public function cannot_save_when_cart_is_empty()
    {
        // pastikan awalnya tidak ada penjualan
        $before = Penjualan::count();

        Livewire::test(TestableInputPenjualan::class)
            ->call('simpan');

        // tidak boleh ada penjualan baru
        $this->assertEquals($before, Penjualan::count(), 'Penjualan seharusnya tidak dibuat jika keranjang kosong');
    }

    /** @test */
    public function cannot_save_when_buyer_money_is_insufficient()
    {
        $product = ManjemenBarang::create([
            'namaproduk' => 'Buku',
            'kategori'   => 'Buku',
            'harga'      => 15000,
            'stok'       => 20,
        ]);

        // buat komponen, tambahkan ke keranjang (default jumlah = 1 => total 15000)
        $component = Livewire::test(TestableInputPenjualan::class)
            ->call('tambahKeKeranjang', $product->id)
            ->set('uangPembeli', 10000); // kurang dari total

        $before = Penjualan::count();

        // coba simpan — seharusnya gagal dan tidak membuat record
        $component->call('simpan');

        $this->assertEquals($before, Penjualan::count(), 'Penjualan tidak boleh dibuat saat uang pembeli tidak cukup');

        // dan keranjang tetap ada (karena simpan gagal)
        $keranjang = $component->get('keranjang');
        $this->assertNotEmpty($keranjang, 'Keranjang harus tetap berisi item jika simpan gagal');
        $this->assertEquals(10000, $component->get('uangPembeli'));
    }

    /** @test */
    public function successful_save_creates_penjualan_and_penjualan_produk_and_resets_state()
    {
        $product = ManjemenBarang::create([
            'namaproduk' => 'Spidol',
            'kategori'   => 'Alat Tulis',
            'harga'      => 8000,
            'stok'       => 50,
        ]);

        $component = Livewire::test(TestableInputPenjualan::class)
            ->set("jumlah.{$product->id}", 3)
            ->call('tambahKeKeranjang', $product->id);

        // total should be 3 * 8000 = 24000
        $component->assertSet('totalHarga', 24000);

        // provide sufficient money
        $component->set('uangPembeli', 30000)
                  ->call('simpan');

        // check that penjualan record created with correct total
        $this->assertDatabaseHas('penjualan', [
            'total_harga' => 24000,
        ]);

        // find created penjualan id
        $penjualan = Penjualan::where('total_harga', 24000)->first();
        $this->assertNotNull($penjualan, 'Penjualan record should exist');

        // check pivot record exists
        $this->assertDatabaseHas('penjualan_produk', [
            'penjualan_id'   => $penjualan->id,
            'produk_id'      => $product->id,
            'jumlah'         => 3,
            'harga_saat_itu' => 8000,
        ]);

        // component state should be reset: keranjang empty and totalHarga = 0
        $component->assertSet('keranjang', []);
        $component->assertSet('totalHarga', 0);
        $component->assertSet('uangPembeli', 0);
    }
}
