<?php

namespace App\Http\Controllers;

use App\Models\KategoriJasa;
use App\Models\PaketProduk;
use App\Models\Pengguna;
use App\Models\Produk;
use App\Models\sertifikat;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class PenyediaJasaController extends Controller
{
    public function index(Request $request)
    {


        $id_pengguna = Pengguna::where('id_user', auth()->user()->id)->value('id');
        // $id_pengguna=Pengguna::where('id_user',auth()->user()->id)->first();

        $data = Produk::with(['kategori', 'paket'])
            ->where(function ($query) use ($request) {
                $query->where('nama', 'like', '%' . $request->search . '%') // Pencarian berdasarkan nama produk
                    ->orWhereHas('kategori', function ($queryKategori) use ($request) {
                        $queryKategori->where('nama', 'like', '%' . $request->search . '%'); // Pencarian berdasarkan nama kategori
                    });
            })
            ->where('id_pengguna', $id_pengguna) // Menampilkan produk milik pengguna yang login
            ->paginate(20);

        // dump($data);
        return view('penyediajasa.produk', compact('data'));
    }

    public function tambah_produk()
    {
        $kategori = KategoriJasa::all();
        // $id_pengguna = Pengguna::where('id_user', auth()->user()->id)->value('id');
        return view('penyediajasa.tambah_data', compact('kategori'));
    }
    public function edit_produk($id_produk)
    {

        $data = Produk::where('id', $id_produk)->first();
        $kategori = KategoriJasa::all();
        $paket = PaketProduk::where('id_produk', $id_produk)
            ->orderByRaw("FIELD(paket, 'silver', 'gold', 'diamond') ASC") // Gantilah 'nama' dengan nama kolom yang sesuai
            ->get();

        // $id_pengguna = Pengguna::where('id_user', auth()->user()->id)->value('id');
        return view('penyediajasa.edit_produk', compact('kategori', 'data', 'paket'));
    }


    public function tambah_produkact(Request $request)
    {
        // dump($request->all());
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',


            'gambar' => 'required|mimes:jpg,png,jpeg|max:20000',
            // Validation for CV
            // 'id_kategorijasa' => 'required|array|min:1', // Validation for Kategori Jasa
            'id_kategori' => 'required|exists:kategori_jasas,id', // Ensure selected categories exist
            // 'paket' => '|array', // Validation for paket
            'paket.*' => 'required|in:silver,gold,diamond', // Ensure each certificate is a valid PDF
            // Validation for deskripsi
            'harga.*' => 'required|string|min:1', // Harga sebagai string karena masih mengandung titik
            'lama_hari.*' => 'required|integer|min:1',
            'deskripsi.*' => 'required|string', // Ensure each skill is a string
        ]);
        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            Alert::error($messages)->flash();
            return back()->withErrors($validator)->withInput();
        }

        $produk = new Produk();
        $produk->nama = $request->nama;
        $produk->id_kategori = $request->id_kategori;

        if ($request->hasFile('gambar')) {
            $fileName = time() . '.' . $request->file('gambar')->getClientOriginalExtension(); //mengambil ekstensi file

            $request->file('gambar')->move(public_path() . '/produk', $fileName); //mengupload file ke public/produk
            $produk->gambar = $fileName;
        }
        $id_pengguna = Pengguna::where('id_user', auth()->user()->id)->value('id');
        $produk->id_pengguna = $id_pengguna;
        $produk->save();


        $paketLabels = ['silver', 'gold', 'diamond'];
        foreach ($paketLabels as $index => $paket) {
            $harga = str_replace('.', '', $request->harga[$index]);
            $paketproduk = new PaketProduk();

            $paketproduk->paket = $paket;
            $paketproduk->harga = $harga;
            $paketproduk->deskripsi = $request->deskripsi[$index];
            $paketproduk->lama_hari = $request->lama_hari[$index];

            // $paketproduk->id_user = $id_pengguna;
            $paketproduk->id_produk = $produk->id;
            $paketproduk->save();
        }
        Alert::success('Success', 'Data Produk berhasil di tambah')->flash();
        return redirect()->route('home_penyediajasa');
    }
    public function update_produk(Request $request, $id_produk)
    {
        // dump($request->all());
        if ($request->hasFile('gambar')) {
            $validator = Validator::make($request->all(), [
                'nama' => 'required|string|max:255',

                'id_paket' => 'required|array|min:1',

                'id_kategori' => 'required|exists:kategori_jasas,id', // Validation for Kategori Jasa
                'paket' => '|array', // Validation for paket
                'paket.*' => 'required|in:silver,gold,diamond', // Ensure each certificate is a valid PDF
                // Validation for deskripsi
                'harga.*' => 'required|string|min:1', // Harga sebagai string karena masih mengandung titik
                'lama_hari.*' => 'required|integer|min:1',
                'deskripsi.*' => 'required|string',
                // Ensure each skill is a string
                'gambar' => 'required|mimes:jpg,png,jpeg|max:20000',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'nama' => 'required|string|max:255',

                'id_paket' => 'required|array|min:1',

                'id_kategori' => 'required|exists:kategori_jasas,id', // Validation for Kategori Jasa
                'paket' => '|array', // Validation for paket
                'paket.*' => 'required|in:silver,gold,diamond', // Ensure each certificate is a valid PDF
                // Validation for deskripsi
                'harga.*' => 'required|string|min:1', // Harga sebagai string karena masih mengandung titik
                'lama_hari.*' => 'required|integer|min:1',
                'deskripsi.*' => 'required|string', // Ensure each skill is a string
            ]);
        }

        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            Alert::error($messages)->flash();
            return back()->withErrors($validator)->withInput();
        }


        $data = Produk::find($id_produk);
        $data->nama = $request->nama;
        $data->id_kategori = $request->id_kategori;
        if ($request->hasFile('gambar')) {
            $file = public_path('/produk/' . $data->gambar);
            @unlink($file);
            $fileName = time() . '.' . $request->file('gambar')->getClientOriginalExtension(); //mengambil ekstensi file

            $request->file('gambar')->move(public_path() . '/produk', $fileName);
            $data->gambar = $fileName;
            //mengupload file ke public/produk
        }

        $data->save();
        foreach ($request->id_paket as $index => $paketId) {
            $paket = PaketProduk::find($paketId);
            if ($paket) {
                $harga = str_replace('.', '', $request->harga[$index]);
                $paket->paket = $request->paket[$index];
                $paket->harga = $harga;
                $paket->deskripsi = $request->deskripsi[$index];
                $paket->lama_hari = $request->lama_hari[$index];
                $paket->save(); // Simpan perubahan paket
            }
        }

        Alert::success('Success', 'Data Produk berhasil di ubah')->flash();
        return redirect()->route('home_penyediajasa');
    }

    public function hapus_produk($id_produk)
    {
        $data = Produk::find($id_produk); //mencari data berdasarkan id
        $file = (public_path('/produk/' . $data->gambar)); //mengambil lokasi file
        if (file_exists($file)) { //jika file ada
            @unlink($file); //menghapus file
        }

        $data->paket()->delete();
        $data->delete(); //menghapus data
        Alert::success('Success', 'Data Berhasil di hapus')->flash();
        return redirect()->route('home_penyediajasa');
    }


    public function dashboard_penyedia()
    {
        $id_pengguna = auth()->user()->pengguna->id;
        return view('penyediajasa.dashboard');
    }


    public function hapus_sertifikat($id)
    {
        $data = sertifikat::find($id);
        $file = (public_path('/sertifikat/' . $data->sertifikat));
        if (file_exists($file)) {
            @unlink($file);
        }
        $data->delete();
        Alert::success('Success', 'Data Sertifikat berhasil di hapus')->flash();
        return redirect()->route('profile');
    }

    public function tambah_sertifikat(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sertifikat' => 'required|mimes:pdf|max:20000',
        ]);
        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            Alert::error($messages)->flash();
            return back()->withErrors($validator)->withInput();
        }
        $data = new sertifikat();
        $data->id_pengguna = auth()->user()->pengguna->id;
        if ($request->hasFile('sertifikat')) {
            $fileName = time() . '.' . $request->file('sertifikat')->getClientOriginalExtension(); //mengambil ekstensi file
            $request->file('sertifikat')->move(public_path() . '/sertifikat', $fileName);
            $data->sertif = $fileName;
            # code...
        }
        // $data->sertif = $fileName;
        $data->save();
        Alert::success('Success', 'Data Sertifikat berhasil di tambah')->flash();
        return redirect()->route('profile');
    }

    public function bukatutup()
    {
        $pengguna = Pengguna::where('id_user', auth()->user()->id)->first();
        $status = auth()->user()->pengguna->status_toko;
        if ($status == "buka") {

            $pengguna->status_toko = "tutup";
            $pengguna->save();
            Alert::success('Success', 'Toko Berhasil di tutup')->flash();
            return redirect()->route('home_penyediajasa');
        } else {

            $pengguna->status_toko = "buka";
            $pengguna->save();
            Alert::success('Success', 'Toko Berhasil di buka')->flash();
            return redirect()->route('home_penyediajasa');
        }
    }

    public function belum_konfirmasii()
    {

        $penggunaId = auth()->user()->pengguna->id;
        $transaksis = Transaksi::with('Detail_transaksi') // Pastikan penamaan relasi konsisten
            // ->where('id_pengguna', $penggunaId)
            ->where('status', 'Belum dikonfirmasi') // Filter berdasarkan status
            ->whereHas('Detail_transaksi', function ($query) use ($penggunaId) {
                $query->where('id_owner', $penggunaId); // Memastikan id_owner sama dengan pengguna yang login
            })
            ->paginate(10);

        return view('penyediajasa.belum_konfirmasi', compact('transaksis'));
    }

    public function konfirmasi(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'id' => 'required|exists:transaksis,id',
            'status'=>'required|in:Dibatalkan,Dikonfirmasi',
        ]);
        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            Alert::error($messages)->flash();
            return back()->withErrors($validator)->withInput();
        }
        $data = Transaksi::find($request->id);
        $data->status = $request->status;
        $data->save();
        Alert::success('Success', 'Konfirmasi Berhasil')->flash();
        return redirect()->route('home_penyediajasa');
    }
}
