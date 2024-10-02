<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriJasaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoriJasas = [
            'struktur',
            'hidrologi',
            'manajemen konstruksi',
            'geoteknik',
            'transportasi',
            'drafter'
        ];

        foreach ($kategoriJasas as $kategori) {
            DB::table('kategori_jasas')->insert([
                'kategori' => $kategori,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
