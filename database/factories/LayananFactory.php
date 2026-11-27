<?php

namespace Database\Factories;

use App\Models\Layanan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Layanan>
 */
class LayananFactory extends Factory
{
    protected $model = Layanan::class;

    public function definition(): array
    {
        $paket = [
            ['nama_layanan' => 'Reguler', 'harga_per_kg' => 7000, 'estimasi_waktu' => '3-4 hari'],
            ['nama_layanan' => 'Ekspres', 'harga_per_kg' => 12000, 'estimasi_waktu' => '1-2 hari'],
            ['nama_layanan' => 'Superkilat', 'harga_per_kg' => 25000, 'estimasi_waktu' => '5 jam selesai'],
        ];

        return fake()->randomElement($paket);
    }
}
