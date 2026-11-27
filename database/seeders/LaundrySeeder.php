<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LaundrySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->updateOrInsert(
            ['email' => 'admin@laundry.test'],
            [
                'name' => 'Admin Laundry',
                'password' => Hash::make('admin123'),
            ]
        );

        DB::table('users')->updateOrInsert(
            ['email' => 'kasir@laundry.test'],
            [
                'name' => 'Kasir Laundry',
                'password' => Hash::make('kasir123'),
            ]
        );

        $layanans = [
            ['nama_layanan' => 'Reguler', 'harga_per_kg' => 7000, 'estimasi_waktu' => '3-4 hari'],
            ['nama_layanan' => 'Ekspres', 'harga_per_kg' => 12000, 'estimasi_waktu' => '1-2 hari'],
            ['nama_layanan' => 'Superkilat', 'harga_per_kg' => 25000, 'estimasi_waktu' => '5 jam selesai'],
        ];

        foreach ($layanans as $item) {
            DB::table('layanans')->updateOrInsert(
                ['nama_layanan' => $item['nama_layanan']],
                $item
            );
        }
    }
}
