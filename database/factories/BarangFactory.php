<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Barang>
 */
class BarangFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kd_brg' => Str::random(5),
            'nm_brg' => $this->faker->name(10), // Menghasilkan kalimat dengan maksimal 6 kata
            'harga' => $this->faker->numberBetween(5000, 50000),
            'stok' => $this->faker->numberBetween(1, 100)
        ];
    }
}
