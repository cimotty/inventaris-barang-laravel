<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kode' => fake()->regexify('[0-1]{2}[.]{1}[0-9]{2}[.]{1}[0-1]{2}[.]{1}[0-9]{2}[.]{1}[0-1]{3}'),
            'nama' => fake()->name(),
            'nomorRegister' => fake()->regexify('[0-9]{4}'),
            'merek' => fake()->name(),
            'tipe' => fake()->name(),
            'tahunBeli' => fake()->date('Y'),
            'kategori' => fake()->randomElement(['Elektronik', 'Furniture', 'Kendaraan']),
            'warna' => fake()->randomElement(['Merah', 'Hijau', 'Biru', 'Hitam', 'Putih']),
            'nomorRangka' => fake()->regexify('[A-Z]{3}[0-9]{6}'),
            'nomorMesin' => fake()->regexify('[A-Z]{3}[0-9]{6}'),
            'nomorPolisi' => fake()->regexify('[A-Z]{2}[ ]{1}[0-9]{4}[ ]{1}[A-Z]{2}'),
            'nomorBpkb' => fake()->regexify('[A-Z]{3}[0-9]{6}'),
            'harga' => fake()->numberBetween(1000000, 10000000),
            'keterangan' => fake()->name(),
        ];
    }
}
