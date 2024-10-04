<?php

namespace Database\Seeders;

use App\Models\KategoriJasa;
use App\Models\Pengguna;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Ambil semua kategori jasa
        $kategoriJasas = KategoriJasa::all();

        // Ambil semua pengguna yang memiliki akses sebagai 'penyedia_jasa'
        $user = User::where('akses', 'penyedia_jasa')->get();
        
        // Dapatkan semua pengguna terkait dari user penyedia jasa
        $penggunaIds = Pengguna::whereIn('id_user', $user->pluck('id'))->pluck('id')->toArray();

        // Jika jumlah pengguna tidak cukup, sesuaikan jumlah loop
        $produkCount = min(15, count($penggunaIds));

        for ($i = 0; $i < $produkCount; $i++) {
            DB::table('produks')->insert([
                'nama' => $faker->name(),
                'id_kategori' => $faker->randomElement($kategoriJasas->pluck('id')->toArray()),
                'id_pengguna' => $penggunaIds[$i],
                'gambar' => 'gambar_' . $i . '.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
