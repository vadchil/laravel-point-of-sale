<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat role admin
        Role::firstOrCreate(
            ['name' => 'admin'],
            ['guard_name' => 'web']
        );

        // Membuat role karyawan
        Role::firstOrCreate(
            ['name' => 'karyawan'],
            ['guard_name' => 'web']
        );

        $this->command->info('Roles berhasil dibuat: admin, karyawan');
    }
}

