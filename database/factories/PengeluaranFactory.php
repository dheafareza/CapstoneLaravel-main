<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pengeluaran>
 */
class PengeluaranFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tgl_pengeluaran' => fake()->dateTimeBetween('-1 month', 'now'),
            'jumlah' => fake()->numberBetween(100000, 5000000),
            'id_sumber_pengeluaran' => fake()->numberBetween(1 ,5),
        ];
    }
}
