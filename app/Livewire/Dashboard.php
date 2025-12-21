<?php

namespace App\Livewire;

use Livewire\Component;

class Dashboard extends Component
{
    public function mount()
    {
        if (auth()->user()->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }

        if (auth()->user()->hasRole('karyawan')) {
            return redirect()->route('karyawan.penjualan');
        }

        // Opsional: Kalau role tidak dikenali
        abort(403, 'Unauthorized');
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
