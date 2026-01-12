<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\Livewire\AdminDashboard;
use App\Livewire\KaryawanDashboard;
use App\Livewire\Dashboard;
use App\Livewire\Karyawan\InputPenjualan;
use App\Livewire\Karyawan\RiwayatPenjualan as KaryawanRiwayatPenjualan;
use App\Livewire\Admin\ManajemenBarang;
use App\Livewire\Admin\RiwayatPenjualan;
use App\Livewire\Admin\UserManagement;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('dashboard', Dashboard::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('admin/dashboard', AdminDashboard::class)->name('admin.dashboard');
    Route::get('admin/manajemenbarang', ManajemenBarang::class)->name('admin.manajemenbarang');
    Route::get('admin/riwayatpenjualan', RiwayatPenjualan::class)->name('admin.riwayatpenjualan');
    Route::get('admin/usermanagement', UserManagement::class)->name('admin.usermanagement');
});

Route::middleware(['auth', 'role:karyawan'])->group(function () {
    Route::get('karyawan/penjualan', InputPenjualan::class)->name('karyawan.penjualan');
    Route::get('karyawan/riwayat', KaryawanRiwayatPenjualan::class)->name('karyawan.riwayat');
});

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

require __DIR__.'/auth.php';
