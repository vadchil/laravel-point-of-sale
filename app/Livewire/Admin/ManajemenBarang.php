<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\ManjemenBarang as Barang;

class ManajemenBarang extends Component
{
    public $namaproduk, $kategori, $harga;
    public $search = '';

    public function store()
    {
        $this->validate([
            'namaproduk' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'harga' => 'required|numeric|min:0',
        ]);

        Barang::create([
            'namaproduk' => $this->namaproduk,
            'kategori' => $this->kategori,
            'harga' => $this->harga,
        ]);

        $this->reset(['namaproduk', 'kategori', 'harga']);
        session()->flash('success', 'Produk berhasil ditambahkan.');
    }

    public function delete($id)
    {
        Barang::findOrFail($id)->delete();
        session()->flash('success', 'Produk berhasil dihapus.');
    }

    public function render()
    {
        $query = Barang::query();

        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('namaproduk', 'like', '%' . $this->search . '%')
                  ->orWhere('kategori', 'like', '%' . $this->search . '%');
            });
        }

        $barangs = $query->latest()->get();
        return view('livewire.admin.manajemen-barang', compact('barangs'));
    }
}
