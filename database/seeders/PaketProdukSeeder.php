<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaketProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $paketTypes = ["silver", "gold", "diamond"];
        
        $produks = DB::table('produks')->pluck('id')->toArray();
        for ($i = 1; $i <= 30; $i++) {
            DB::table('paket_produks')->insert([
                'paket' => $paketTypes[array_rand($paketTypes)], // Random paket type
                'harga' => rand(100000, 1000000), // Random price between 100,000 and 1,000,000
                'deskripsi' => 'Paket ' . $i . ' - Deskripsi produk yang menarik.',
                'lama_hari' => rand(7, 30), // Random duration between 7 and 30 days
                // 'id_produk' => rand(1, 10),
                 // Sesuaikan dengan jumlah produk yang ada di tabel 'produks'
                'id_produk' => $produks[array_rand($produks)],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
