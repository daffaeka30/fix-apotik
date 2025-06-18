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
        $kodeProduk = 'Produk/' .now()->format('m'). '/' . now()->format('y').'/' . fake()->numerify('####');

        return [
            'id_kategori' => rand(1, 2),
            'kode_produk' => $kodeProduk,
            'nama_produk' => fake()->name(),
            'merk' => fake()->name(),
            'harga_beli' => rand(10000, 50000),
            'diskon' => rand(0, 50),
            'harga_jual' => rand(10000, 50000),
            'stok' => rand(1, 100),
            'satuan' => fake()->randomElement(['Tablet', 'Kapsul', 'Pil', 'Botol', 'Mililiter', 'Lembar']),
            'expired' => now()->addDays(rand(1, 30)),
        ];
    }
}
