<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produk>
 */
class ProdukFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'NamaProduk'=>$this->faker->word(),
            'Harga'=>$this->faker->randomElement([1000,5000,10000,20000,50000,10000,500,1500]),
            'Stok'=>100
        ];
    }
}
