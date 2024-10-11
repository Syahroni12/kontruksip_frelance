<?php

namespace App\Console\Commands;

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
        $transactions = Transaksi::where('tgl_akhir', '<', Carbon::now())
            ->where('status', '!=', 'Selesai') // Menghindari update pada transaksi yang sudah 'Selesai'
            ->get();

        foreach ($transactions as $transaction) {
            $transaction->status = 'Selesai'; // Ubah status sesuai kebutuhan
            $transaction->save();
            $this->info('Updated status for transaction ID: ' . $transaction->id);
        }

        $this->info('Transaction status update completed.');
    }
}
