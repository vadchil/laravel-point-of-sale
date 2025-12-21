<?php

namespace Database\Factories;

use App\Models\ManjemenBarang;
use Illuminate\Database\Eloquent\Factories\Factory;

class ManjemenBarangFactory extends Factory
{
    protected $model = ManjemenBarang::class;

    public function definition(): array
    {
        return [
            'namaproduk' => $this->faker->word(),
            'kategori'   => $this->faker->randomElement(['kategori1','kategori2','kategori3']),
            'harga'      => $this->faker->numberBetween(10000, 500000),
        ];
    }
}
