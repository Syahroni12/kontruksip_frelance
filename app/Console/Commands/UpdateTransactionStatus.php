<?php

namespace App\Console\Commands;

use App\Models\Pengguna;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateTransactionStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    protected $signature = 'transactions:update-status';
    protected $description = 'Update transaction status based on the end date';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Ambil semua transaksi yang tgl_akhir kurang dari tanggal sekarang
        $transactions = Transaksi::with('Detail_transaksi')
            ->where('tgl_akhir', '<', Carbon::now())
            ->where('status', 'Sedang konsultasi')
            ->get();

        foreach ($transactions as $transaction) {
            $totalHarga = 0;

            // Ambil detail transaksi untuk setiap transaksi
            $detail = $transaction->Detail_transaksi; // Mengambil satu detail transaksi

            if ($detail) { // Memastikan detail transaksi ditemukan
                // Proses saldo pengguna
                $owner = Pengguna::find($detail->id_owner);
                if ($owner) {
                    $owner->saldo += $detail->harga;
                    $owner->save();
                }

                // Ubah status transaksi menjadi 'Selesai'
                $transaction->status = "Selesai";
                $transaction->save();
                $this->info('Updated status for transaction ID: ' . $transaction->id);
            } else {
                $this->info('No detail found for transaction ID: ' . $transaction->id);
                // dd("dksdksd");
            }
        }
    }
}
