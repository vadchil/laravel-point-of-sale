<?php

namespace Tests\Feature\Livewire\Admin;

use Tests\TestCase;
use Livewire\Livewire;
use App\Livewire\Admin\ManajemenBarang as ManajemenBarangComponent;
use App\Models\ManjemenBarang;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManajemenBarangTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_validates_and_creates_barang()
    {
        Livewire::test(ManajemenBarangComponent::class)
            ->set('namaproduk', '')
            ->set('kategori', '')
            ->set('harga', '')
            ->call('store')
            ->assertHasErrors(['namaproduk', 'kategori', 'harga']);

        Livewire::test(ManajemenBarangComponent::class)
            ->set('namaproduk', 'Produk A')
            ->set('kategori', 'Kategori A')
            ->set('harga', 50000)
            ->call('store');

        $this->assertDatabaseHas('manajemenbarang', [
            'namaproduk' => 'Produk A',
            'kategori' => 'Kategori A',
            'harga' => 50000,
        ]);
    }

    /** @test */
    public function it_deletes_barang()
    {
        $barang = ManjemenBarang::factory()->create();

        Livewire::test(ManajemenBarangComponent::class)
            ->call('delete', $barang->id);

        $this->assertDatabaseMissing('manajemenbarang', [
            'id' => $barang->id,
        ]);
    }
}
