<?php

namespace App\Http\Controllers;

use App\Mail\AktivasiAkun;
use App\Models\Pengguna;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{
    public function register_awal()
    {
        return view('auth.register_first');
    }
    public function register_customer()
    {
        return view('auth.register_customer');
    }

    public function login_page()
    {
        // dd("");
        return view('auth.login');
    }

    public function daftar_customer(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users', //validasi email dan uniique untuk di tabel user dengan field email
            'password' => 'required|string|min:8', //validasi password dan min 8
            'password2' => 'required_with:password|same:password',
            'alamat' => 'required', //validasi alamat
            'notelp' => 'required|numeric|min:11', //validasi no hp supaya angka ajaa
            //validasi no hp supaya angka ajaa
            'tgllahir' => 'required|date',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'foto' => 'required|mimes:jpg,png,jpeg|max:10000',
        ]);
        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            Alert::error($messages)->flash();
            return back()->withErrors($validator)->withInput();
        }
        $tanggal = Carbon::parse($request->tgllahir)->format('Y-m-d');
        $umur = $this->hitungUmur($tanggal);

        // dd($umur);
        if ($umur < 17) {
            Alert::error('Anda harus berusia 17 tahun keatas')->flash();
            return back()->withInput();
            # code...
        }
        //DB::beginTransaction(); merupakan fungsi untuk memulai transaksi di database
        // DB::beginTransaction();
        // try {
        //code...


        try {
            Mail::to($request->email)->send(new AktivasiAkun());
            $user = new User(); //membuat objek user
        // $user->name = $request->nama;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->akses = "customer";
        $user->status = "aman";
        $user->save(); //fungsi save untuk menyimpan data ke database di tabel user
        $pengguna = new Pengguna();
        $pengguna->id_user = $user->id;
        $pengguna->nama = $request->nama;
        $pengguna->alamat = $request->alamat;
        $pengguna->notelp = $request->notelp;
        $pengguna->tgllahir = $request->tgllahir;
        $fileName = time() . '.' . $request->file('foto')->getClientOriginalExtension(); //mengambil ekstensi file

        $request->file('foto')->move(public_path() . '/foto_profile', $fileName); //mengupload file ke public/produk
        $pengguna->foto = $fileName;
        $pengguna->save();
            Alert::success('Success', 'Berhasil Registrasi silahkan cek email')->flash();
        // DB::commit();//fungsi commit untuk menyelesaikan transaksi di database ATAU DI masukkan
        return redirect()->route('register_customer');
        } catch (\Exception $e) {
            // Handle the error, for example:

            // return redirect()->back()->withInput();
            Alert::error('Email tidak valid')->flash();
            return back()->withInput();
            
        }
         //fungsi save untuk menyimpan data ke database di tabel pelanggan
       
        



        // DB::commit();
        // } catch (\Exception $th) {
        //     DB::rollBack();
        //     Alert::error('Error', $th->getMessage())->flash();
        //     return back()->withErrors($validator)->withInput();


        // }
    }


    public function hitungUmur($tanggalLahir)
    {
        // Menggunakan Carbon untuk menghitung umur
        $tanggalLahir = Carbon::parse($tanggalLahir);
        $umur = $tanggalLahir->age;

        return $umur;
    }
}
