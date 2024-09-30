<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Pengguna;
use App\Models\User;


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
        ->select('users.email', 'users.akses', 'users.status', 'penggunas.nama', 'penggunas.notelp', 'penggunas.gender', 'penggunas.CV', 'penggunas.alamat', 'penggunas.foto', 'penggunas.tgllahir', 'penggunas.no_rekening', 'penggunas.pendidikan_terakhir')
        ->where('users.akses', 'penyedia_jasa') // Filter for penyedia_jasa
        ->get();

    // Pass data to the view
    return view('admin.penyedia_jasa.index', ['data' => $data]);
}

public function update(Request $request, $id)
{
    // Validasi data
    $request->validate([
        'status' => 'required|in:aman,blokir,sedang_verifikasi',
        'akses' => 'required|in:customer,penyedia_jasa,customer_penyediajasa',
    ]);

    // Update data penyedia jasa
    $user = User::findOrFail($id);
    $user->status = $request->input('status');
    $user->akses = $request->input('akses');
    $user->save();

    // Redirect dengan pesan sukses
    return redirect()->route('penyediajasa.index')->with('success', 'Data penyedia jasa berhasil diperbarui.');
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
    return redirect()->route('penyediajasa.index')->with('success', 'Data penyedia jasa berhasil dihapus.');
}


}
