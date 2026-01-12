<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Membuat roles terlebih dahulu
        $this->call(RoleSeeder::class);

        // Membuat user admin default
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
            ]
        );

        // Assign role admin jika belum punya role
        if (!$admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }

        $this->command->info('User admin default dibuat:');
        $this->command->info('Email: admin@example.com');
        $this->command->info('Password: password');
        $this->command->warn('⚠️  Jangan lupa ubah password setelah login pertama kali!');

        // Membuat user karyawan contoh (opsional)
        $karyawan = User::firstOrCreate(
            ['email' => 'karyawan@example.com'],
            [
                'name' => 'Karyawan Contoh',
                'password' => Hash::make('password'),
            ]
        );

        if (!$karyawan->hasRole('karyawan')) {
            $karyawan->assignRole('karyawan');
        }

        $this->command->info('User karyawan contoh dibuat:');
        $this->command->info('Email: karyawan@example.com');
        $this->command->info('Password: password');
    }
}
