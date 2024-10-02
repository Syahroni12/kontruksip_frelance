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


class CustomerAdminController extends Controller
{
    public function index() {
        return view('admin.customer.index');
    }

    public function getDataCustomer(Request $request)
    {
        // Fetch data using join query
        $data = DB::table('users')
            ->join('penggunas', 'penggunas.id_user', '=', 'users.id')
            ->select('users.id','users.email', 'users.akses', 'users.status', 'penggunas.nama', 'penggunas.notelp', 'penggunas.gender','penggunas.alamat', 'penggunas.id_user', 'penggunas.foto', 'penggunas.tgllahir',)
            ->whereIn('users.akses', ['customer', 'customer_penyediajasa']) // Use whereIn for multiple values
            ->where('users.status', 'aman') // Use where for single value
            ->get();

        return view('admin.customer.index', ['customer' => $data]);
    }

    public function getDataCustomerDiblokir(Request $request)
    {
        // Fetch data using join query
        $data = DB::table('users')
            ->join('penggunas', 'penggunas.id_user', '=', 'users.id')
            ->select('users.id','users.email', 'users.akses', 'users.status', 'penggunas.nama', 'penggunas.notelp', 'penggunas.gender', 'penggunas.CV', 'penggunas.alamat', 'penggunas.foto', 'penggunas.tgllahir', 'penggunas.no_rekening', 'penggunas.pendidikan_terakhir')
            ->whereIn('users.akses', ['customer', 'customer_penyediajasa']) // Use whereIn for multiple values
            ->where('users.status', 'blokir') // Use where for single value
            ->get();

        // Pass data to the view
        return view('admin.customer.customer_diblokir', ['customer' => $data]);
    }

    public function update_status(Request $request)
    {
        // Validasi input
        $request->validate([
            'id' => 'required|exists:users,id', // Pastikan ID ada
            'status' => 'required|in:aman,blokir',
        ]);

        // Cari user berdasarkan ID
        $user = User::findOrFail($request->input('id'));

        // Update data status
        $user->status = $request->input('status');
        $user->save();

        // Kirim email
        Mail::to($user->email)->send(new VerivikasiAdmin($user->status));

        // Redirect kembali dengan pesan sukses
        Alert::success('Success', 'Berhasil Verivikasi User')->flash();
        return redirect()->route('show_customer_admin');
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
    return redirect()->route('show_customer_admin')->with('success', 'Data User berhasil dihapus.');
}

}
