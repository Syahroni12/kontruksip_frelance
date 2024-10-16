<?php

namespace App\Http\Controllers;

use App\Mail\AktivasiAkun;
use App\Mail\penyedia_jasadaftar;
use App\Models\KategoriJasa;
use App\Models\kategorijasa_user;
use App\Models\Keahlian;
use App\Models\Pengguna;
use App\Models\sertifikat;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


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

    public function register_klien()
    {
        $kategori_jasa = KategoriJasa::all();
        return view('auth.register_klien', compact('kategori_jasa'));
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
    public function daftar_klien(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'password2' => 'required_with:password|same:password',
            'alamat' => 'required',
            'deskripsi' => 'required',
            'notelp' => 'required|numeric|min:11',
            'tgllahir' => 'required|date',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'foto' => 'required|mimes:jpg,png,jpeg|max:10000',
            'no_rekening' => 'required|numeric',
            'jenis_rekening' => 'required|in:Bank Mandiri,BCA,BNI,BRI,BSI,GoPay,OVO,DANA,ShopeePay,LinkAja',
            // Validation for No Rekening
            'pendidikan_terakhir' => 'required|string|max:255', // Validation for Last Education
            'CV' => 'required|mimes:pdf|max:20000', // Validation for CV
            // 'id_kategorijasa' => 'required|array|min:1', // Validation for Kategori Jasa
            'id_kategori' => 'required|exists:kategori_jasas,id', // Ensure selected categories exist
            'sertifikat' => 'required|array|min:1', // Validation for Sertifikat
            'sertifikat.*' => 'mimes:pdf|max:20000', // Ensure each certificate is a valid PDF
            'keahlian' => 'required|array|min:1', // Validation for Keahlian
            'keahlian.*' => 'string|max:255', // Ensure each skill is a string
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


        // try {
        $admin = User::where('akses', 'admin')->first();


        $user = new User(); //membuat objek user
        // $user->name = $request->nama;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->akses = "penyedia_jasa";
        $user->status = "sedang_verifikasi";
        $user->save(); //fungsi save untuk menyimpan data ke database di tabel user
        Mail::to($admin->email)->send(new penyedia_jasadaftar($user));
        $pengguna = new Pengguna();
        $pengguna->id_user = $user->id;
        $pengguna->nama = $request->nama;
        $pengguna->jenis_rekening = $request->jenis_rekening;
        $pengguna->alamat = $request->alamat;
        $pengguna->deskripsi = $request->deskripsi;
        $pengguna->notelp = $request->notelp;
        $pengguna->pendidikan_terakhir = $request->pendidikan_terakhir;
        $pengguna->no_rekening = $request->no_rekening;
        $pengguna->gender = $request->gender;
        $pengguna->id_kategori = $request->id_kategori;



        $pengguna->tgllahir = $request->tgllahir;
        $fileName = time() . '.' . $request->file('foto')->getClientOriginalExtension(); //mengambil ekstensi file

        $request->file('foto')->move(public_path() . '/foto_profile', $fileName); //mengupload file ke public/produk
        $pengguna->foto = $fileName;
        $fileNameCV = time() . '.' . $request->file('CV')->getClientOriginalExtension(); //mengambil ekstensi file

        $request->file('CV')->move(public_path() . '/CV_profile', $fileNameCV); //mengupload file ke public/produk
        $pengguna->CV = $fileNameCV;
        $pengguna->save();
        foreach ($request->keahlian as $keahlian) {
            Keahlian::create([
                'id_pengguna' => $pengguna->id, // Assuming a relationship with user
                'keahlian' => $keahlian,
            ]);
        }



        foreach ($request->file('sertifikat') as $sertifikat) {
            // Menghasilkan nama unik untuk file sertifikat
            $sertifikatName = time() . '.' . $sertifikat->getClientOriginalExtension(); // Mengambil ekstensi file

            // Memindahkan file yang diunggah ke direktori yang ditentukan
            $sertifikat->move(public_path('sertifikat'), $sertifikatName); // Memindahkan file ke public/sertifikat

            // Membuat record Sertifikat baru di database
            Sertifikat::create([
                'id_pengguna' => $pengguna->id, // Mengasumsikan adanya hubungan dengan pengguna
                'sertif' => $sertifikatName // Menyimpan nama file
            ]);
        }



        Alert::success('Success', 'Berhasil Registrasi tunggu verifikasi dari Admin')->flash();
        // DB::commit();//fungsi commit untuk menyelesaikan transaksi di database ATAU DI masukkan
        return redirect()->route('login');
        // } catch (\Exception $e) {
        //     // Handle the error, for example:

        //     // return redirect()->back()->withInput();
        //     Alert::error('Email tidak valid')->flash();
        //     return back()->withInput();
        // }
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



    // login admin



    public function loginact(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            alert('Gagal', $validator->messages());
            return redirect()->back()->withInput();
        }

        $credentials = [
            "email" => $request->email,
            "password" => $request->password
        ];
        try {

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                if (Auth::user()->akses == 'penyedia_jasa') {
                    // dd(Auth::user()->akses);
                    if (Auth::user()->status == 'aman') {
                        User::where('id', Auth::user()->id)->update(['status_login' => true]);
                        Alert::success('Success', 'Login Berhasil di lakukan')->flash();
                        return redirect()->route('home_penyediajasa');
                    } elseif (Auth::user()->status == 'blokir') {
                        Auth::logout();
                        $request->session()->invalidate();
                        $request->session()->regenerateToken();
                        Alert::error('Gagal', 'Akun anda diblokir')->flash();
                        return back()->withInput();
                        // dd(Auth::user()->akses);
                    } else {
                        Auth::logout();
                        $request->session()->invalidate();
                        $request->session()->regenerateToken();
                        Alert::error('Gagal', 'Akun anda sedang diverifikasi')->flash();
                        return back()->withInput();
                    }
                    // } elseif(Auth::user()->akses == 'customer') {
                    //     Alert::success('Success', 'Login Berhasil di lakukan')->flash();
                    //     return dd(Auth::user()->akses);
                } elseif (Auth::user()->akses == 'admin') {
                    if (Auth::user()->status == 'aman') {
                        Alert::success('Success', 'Login Berhasil di lakukan')->flash();
                        return redirect()->route('show_dashboard_admin');
                    } elseif (Auth::user()->status == 'blokir') {
                        Auth::logout();
                        $request->session()->invalidate();
                        $request->session()->regenerateToken();
                        Alert::error('Gagal', 'Akun anda diblokir')->flash();
                        return back()->withInput();
                        // dd(Auth::user()->akses);
                    } else {
                        Auth::logout();
                        $request->session()->invalidate();
                        $request->session()->regenerateToken();
                        Alert::error('Gagal', 'Akun anda sedang diverifikasi')->flash();
                        return back()->withInput();
                    }
                } elseif (Auth::user()->akses == 'customer') {

                    User::where('id', Auth::user()->id)->update(['status_login' => true]);
                    Alert::success('success', 'Berhasil login')->flash();
                    // dd("sddsdsd");
                    return redirect()->route('home_customer');
                }

                // dd(Auth::user()->akses);

                // return redirect()->intended('dashboard');
            } else {
                Alert::error('Gagal', "email atau password salah");
                return back();
            }
        } catch (\Throwable $th) {
            //throw $th;
            alert()->error('Gagal', $th->getMessage());
            return back();
            //     alert()->error('Gagal',"nis/nip atau password salah");
            // return back();
        }
    }


    public function profile()
    {
        $data = Pengguna::where('id_user', auth()->user()->id)->first();
        $keahlian  = Keahlian::where('id_pengguna', $data->id)->get();
        $sertifikat = Sertifikat::where('id_pengguna', $data->id)->get();
        // dump($sertifikat);
        if (auth()->user()->akses == 'customer') {
            return view('customer.profile_customer', compact('data'));
            # code...
        } else {
            return view('penyediajasa.profile_penyediajasa', compact('data', 'keahlian', 'sertifikat'));
        }
    }

    public function profile_customeract(Request $request)
    {
        if ($request->hasFile('gambar')) {
            $validator = Validator::make($request->all(), [
                'nama' => 'required|string|max:255',

                'alamat' => 'required', //validasi alamat
                'notelp' => 'required|numeric|min:11', //validasi no hp supaya angka ajaa
                //validasi no hp supaya angka ajaa

                'gender' => 'required|in:Laki-laki,Perempuan',
                'foto' => 'required|mimes:jpg,png,jpeg|max:10000',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'nama' => 'required|string|max:255',

                'alamat' => 'required', //validasi alamat
                'notelp' => 'required|numeric|min:11', //validasi no hp supaya angka ajaa
                //validasi no hp supaya angka ajaa

                'gender' => 'required|in:Laki-laki,Perempuan',
                // 'foto' => 'required|mimes:jpg,png,jpeg|max:10000',
            ]);
        }



        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            Alert::error($messages)->flash();
            return back()->withErrors($validator)->withInput();
        }

        if ($request->password != null) {
            $user = User::find(auth()->user()->id);
            $user->password = Hash::make($request->password);
            $user->save();
        }

        $data = Pengguna::where('id_user', auth()->user()->id)->first();

        $data->nama = $request->nama;
        $data->alamat = $request->alamat;
        $data->notelp = $request->notelp;
        $data->gender = $request->gender;
        // $data->id_kategori = $request->id_kategori;
        if ($request->hasFile('foto')) {
            $file = public_path('/foto_profile/' . $data->foto);
            @unlink($file);
            $fileName = time() . '.' . $request->file('foto')->getClientOriginalExtension(); //mengambil ekstensi file

            $request->file('foto')->move(public_path() . '/foto_profile', $fileName);
            $data->foto = $fileName;
            //mengupload file ke public/produk
        }

        $data->save();
        Alert::success('Success', 'Profile Berhasil di lakukan')->flash();
        return redirect()->route('profile');
    }



    public function logout(Request $request)
    {
        //fungsi logout

        User::where('id', auth()->user()->id)->update([
            'status_login' => false,
        ]);
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Alert::success('Success', 'Logout Berhasil di lakukan')->flash();
        return redirect()->route('login');
    }
}
