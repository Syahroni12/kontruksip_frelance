<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Faker\Factory as Faker;

class PenggunasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $genderOptions = ['Laki-laki', 'Perempuan'];

        // Buat array dari 1 sampai 15, kemudian di-shuffle untuk mengacak urutannya
        $userIds = range(1, 15);
        shuffle($userIds);  // Mengacak array sehingga urutannya random

        for ($i = 0; $i < 15; $i++) {
            DB::table('penggunas')->insert([
                'nama' => $faker->name(),
                'notelp' => $faker->phoneNumber(),
                'gender' => $faker->randomElement($genderOptions),
                'CV' => $faker->randomElement([null, 'cv_' . $i . '.pdf', 'cv_' . $i . '.docx']),
                'alamat' => $faker->address(),
                'foto' => 'foto_' . $i . '.jpg',  // Asumsi menggunakan nama file foto acak
                'tgllahir' => $faker->date(),
                'no_rekening' => $faker->randomElement([null, $faker->bankAccountNumber()]),
                'pendidikan_terakhir' => $faker->randomElement(['SMA', 'Diploma', 'Sarjana', null]),
                'id_user' => $userIds[$i],  // Mengambil id_user dari array yang telah di-shuffle
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
