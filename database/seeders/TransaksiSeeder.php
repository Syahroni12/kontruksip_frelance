<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Pengguna;
use App\Models\PaketProduk;

class TransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $metodePembayaran = [
            'Bank Mandiri', 'BCA', 'BNI', 'BRI', 'BSI',
            'GoPay', 'OVO', 'DANA', 'ShopeePay', 'LinkAja'
        ];

        $statusTransaksi = ["Sudah bayar", "Sedang konsultasi", "Selesai", "Dibatalkan"];

        // Ambil semua id_pengguna dan id_paketproduk yang valid
        $penggunaIds = Pengguna::pluck('id')->toArray();
        $paketProdukIds = PaketProduk::pluck('id')->toArray();

        for ($i = 1; $i <= 30; $i++) {
            $lamaHari = rand(7, 30);
            $tglAwal = now()->subDays(rand(1, 60));
            $tglAkhir = $tglAwal->copy()->addDays($lamaHari);

            // Pilih id_pengguna dan id_paketproduk secara acak dari yang valid
            $idPengguna = $penggunaIds[array_rand($penggunaIds)];
            $idPaketProduk = $paketProdukIds[array_rand($paketProdukIds)];

            DB::table('transaksis')->insert([
                'id_pengguna' => $idPengguna,
                'id_paketproduk' => $idPaketProduk,
                'tgl_awal' => $tglAwal,
                'tgl_akhir' => $tglAkhir,
                'lama_hari' => $lamaHari,
                'deskripsi' => 'Transaksi ' . $i . ' - Deskripsi transaksi yang menarik.',
                'total_harga' => rand(500000, 5000000),
                'metode' => $metodePembayaran[array_rand($metodePembayaran)],
                'status' => $statusTransaksi[array_rand($statusTransaksi)],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
