<?php

namespace Database\Factories;

use App\Models\Penjualan;
use Illuminate\Database\Eloquent\Factories\Factory;

class PenjualanFactory extends Factory
{
    protected $model = Penjualan::class;

    public function definition(): array
    {
        return [
            'tanggal' => now(),
            'total_harga' => $this->faker->numberBetween(10000, 100000),
            // tambahkan kolom lain jika ada
        ];
    }
}
