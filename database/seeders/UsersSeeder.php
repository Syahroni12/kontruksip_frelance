<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;


class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $aksesOptions = ['admin', 'customer', 'penyedia_jasa', 'customer_penyediajasa'];
        $statusOptions = ['aman', 'blokir', 'sedang_verifikasi'];

        for ($i = 0; $i < 15; $i++) {
            DB::table('users')->insert([
                'email' => $faker->unique()->safeEmail(),
                'akses' => $faker->randomElement($aksesOptions),
                'status' => $faker->randomElement($statusOptions),
                'password' => Hash::make('password123'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
