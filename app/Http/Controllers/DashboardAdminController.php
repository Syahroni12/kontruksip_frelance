<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;

class DashboardAdminController extends Controller
{
    // public function index() {
    //     return view('admin.dashboard.index');
    // }

    public function index() {
        // Fetch data using join query based on the correct table structure
        $data = DB::table('transaksis')
            ->join('penggunas as pembeli', 'pembeli.id', '=', 'transaksis.id_pengguna')
            ->join('users as pembeli_user', 'pembeli.id_user', '=', 'pembeli_user.id')
            ->join('paket_produks', 'paket_produks.id', '=', 'transaksis.id_paketproduk')
            ->join('produks', 'produks.id', '=', 'paket_produks.id_produk')
            ->join('penggunas as penjual', 'penjual.id', '=', 'produks.id_pengguna')
            ->join('users as penjual_user', 'penjual.id_user', '=', 'penjual_user.id')
            ->select(
                'pembeli.nama as nama_pembeli',
                'penjual.nama as nama_penjual',
                'pembeli_user.email as email_pembeli',
                'penjual_user.email as email_penjual',
                'produks.nama as nama_produk',
                'transaksis.tgl_awal',
                'transaksis.tgl_akhir',
                DB::raw('DATEDIFF(transaksis.tgl_akhir, transaksis.tgl_awal) as lama_hari'),
                'transaksis.deskripsi',
                'transaksis.total_harga',
                'transaksis.status'
            )
            ->orderBy('transaksis.id', 'desc')
            ->paginate(20);

        // Pass the data to the view
        return view('admin.transaksi.index', ['transaksisAll' => $data]);
    }

    public function chartDashboard()
    {


        // Grouping orders by month and status_pesanan
        $pesananData = Transaksi::selectRaw('MONTH(tgl_awal) as bulan, status_pesanan, COUNT(*) as total')
            ->groupBy(DB::raw('MONTH(tgl_awal)'), 'status_pesanan')
            ->get();

        // Initialize data for each status and month
        $statusLabels = ['Sudah bayar', 'Sedang konsultasi', 'Selesai', 'Dibatalkan'];
        $dataPerStatus = [];

        // Prepare an array for 12 months (January to December)
        foreach ($statusLabels as $status) {
            $dataPerStatus[$status] = array_fill(1, 12, 0);
        }

        // Fill the array with query data
        foreach ($pesananData as $data) {
            $dataPerStatus[$data->status_pesanan][$data->bulan] = $data->total;
        }

        return view('admin.dashboard.index', );
    }


}
