<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\VerivikasiAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Pengguna;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;

class VerfikasiPenyedaJasaAdminController extends Controller
{
    public function index() {
        return view('admin.penyedia_jasa.index');
    }

    public function getDataPenyediaJasa(Request $request)
    {
        // Fetch data using join query
        $data = DB::table('users')
            ->join('penggunas', 'penggunas.id_user', '=', 'users.id')
            ->select('users.id','users.email', 'users.akses', 'users.status', 'penggunas.nama', 'penggunas.notelp', 'penggunas.gender', 'penggunas.CV', 'penggunas.alamat', 'penggunas.foto', 'penggunas.tgllahir', 'penggunas.no_rekening', 'penggunas.pendidikan_terakhir')
            ->whereIn('users.akses', ['penyedia_jasa', 'customer_penyediajasa']) // Use whereIn for multiple values
            ->get();

        // Pass data to the view
        return view('admin.penyedia_jasa.index', ['penyediaJasa' => $data]); // Use 'penyediaJasa' instead of 'data'
    }

    public function getDataPenyediaJasaDiblokir(Request $request)
    {
        // Fetch data using join query
        $data = DB::table('users')
            ->join('penggunas', 'penggunas.id_user', '=', 'users.id')
            ->select('users.id','users.email', 'users.akses', 'users.status', 'penggunas.nama', 'penggunas.notelp', 'penggunas.gender', 'penggunas.CV', 'penggunas.alamat', 'penggunas.foto', 'penggunas.tgllahir', 'penggunas.no_rekening', 'penggunas.pendidikan_terakhir')
            ->whereIn('users.akses', ['penyedia_jasa', 'customer_penyediajasa']) // Use whereIn for multiple values
            ->where('users.status', 'blokir') // Use where for single value
            ->get();

        // Pass data to the view
        return view('admin.penyedia_jasa.penyedia_jasa_diblokir', ['penyediaJasa' => $data]); // Use 'penyediaJasa' instead of 'data'
    }

    public function getDataPenyediaJasaBelumVerifikasi(Request $request)
    {
        // Fetch data using join query
        $data = DB::table('users')
            ->join('penggunas', 'penggunas.id_user', '=', 'users.id')
            ->select('users.id','users.email', 'users.akses', 'users.status', 'penggunas.nama', 'penggunas.notelp', 'penggunas.gender', 'penggunas.CV', 'penggunas.alamat', 'penggunas.foto', 'penggunas.tgllahir', 'penggunas.no_rekening', 'penggunas.pendidikan_terakhir')
            ->whereIn('users.akses', ['penyedia_jasa', 'customer_penyediajasa']) // Use whereIn for multiple values
            ->where('users.status', 'sedang_verifikasi') // Use where for single value
            ->get();

        // Pass data to the view
        return view('admin.penyedia_jasa.penyedia_jasa_verifikasi', ['penyediaJasa' => $data]); // Use 'penyediaJasa' instead of 'data'
    }

    public function getDataPenyediaJasaAman(Request $request)
    {
        // Fetch data using join query
        $data = DB::table('users')
            ->join('penggunas', 'penggunas.id_user', '=', 'users.id')
            ->select('users.id','users.email', 'users.akses', 'users.status', 'penggunas.nama', 'penggunas.notelp', 'penggunas.gender', 'penggunas.CV', 'penggunas.alamat', 'penggunas.foto', 'penggunas.tgllahir', 'penggunas.no_rekening', 'penggunas.pendidikan_terakhir')
            ->whereIn('users.akses', ['penyedia_jasa', 'customer_penyediajasa']) // Use whereIn for multiple values
            ->where('users.status', 'aman') // Use where for single value
            ->get();

        // Pass data to the view
        return view('admin.penyedia_jasa.penyedia_jasa_aman', ['penyediaJasa' => $data]); // Use 'penyediaJasa' instead of 'data'
    }

    public function update_status(Request $request)
    {
        // Validasi input
        $request->validate([
            'status' => 'required|in:aman,blokir,sedang_verifikasi',
            'akses' => 'required|in:customer,penyedia_jasa,customer_penyediajasa',
        ]);

        // Cari user berdasarkan ID
        $user = User::findOrFail($request->input('id'));

        // Update data status dan akses
        $user->status = $request->input('status');
        $user->akses = $request->input('akses');
        $user->save();
        Mail::to($user->email)->send(new VerivikasiAdmin($user->status));
        // Redirect kembali dengan pesan sukses
        Alert::success('Success', 'Berhasil Verivikasi User')->flash();
        return redirect()->route('show_penyedia_jasa_admin');
    }


public function destroy($id)
{
    // Cari pengguna berdasarkan id_user yang berhubungan dengan tabel users
    $pengguna = Pengguna::where('id_user', $id)->first();
    if ($pengguna) {
        // Hapus data dari tabel penggunas
        $pengguna->delete();
    }

    // Hapus data dari tabel users
    $user = User::findOrFail($id);
    $user->delete();

    // Redirect dengan pesan sukses
    return redirect()->route('show_penyedia_jasa_admin')->with('success', 'Data penyedia jasa berhasil dihapus.');
}


}
