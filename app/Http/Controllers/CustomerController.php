<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\detail_transaksi;
use App\Models\KategoriJasa;
use App\Models\PaketProduk;
use App\Models\Pengguna;
use App\Models\Produk;
use App\Models\Keahlian;
use App\Models\Raiting;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Midtrans\Snap;
use RealRashid\SweetAlert\Facades\Alert;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $kategori = KategoriJasa::all();
        $id_pengguna = Pengguna::where('id_user', auth()->user()->id)->value('id');
        // $id_pengguna=Pengguna::where('id_user',auth()->user()->id)->first();

        $data = Produk::with(['kategori', 'paket'])
            ->where(function ($query) use ($request) {
                $query->where('nama', 'like', '%' . $request->search . '%') // Pencarian berdasarkan nama produk
                    ->orWhereHas('kategori', function ($queryKategori) use ($request) {
                        $queryKategori->where('nama', 'like', '%' . $request->search . '%'); // Pencarian berdasarkan nama kategori
                    });
            })
            ->where('id_pengguna', '!=', $id_pengguna) // Menampilkan produk yang tidak dimiliki oleh pengguna yang login
            ->paginate(30);

        // dump($data);
        // return view('penyediajasa.produk', compact('data'));
        return view('customer.dashboard_customer', compact('data', 'kategori'));
    }
    public function indexkategori(Request $request, $id)
    {
        $kategori = KategoriJasa::all();
        $id_pengguna = Pengguna::where('id_user', auth()->user()->id)->value('id');
        // $id_pengguna=Pengguna::where('id_user',auth()->user()->id)->first();

        $data = Produk::with(['kategori', 'paket'])
            ->where(function ($query) use ($request) {
                $query->where('nama', 'like', '%' . $request->search . '%') // Pencarian berdasarkan nama produk
                    ->orWhereHas('kategori', function ($queryKategori) use ($request) {
                        $queryKategori->where('nama', 'like', '%' . $request->search . '%'); // Pencarian berdasarkan nama kategori
                    });
            })
            ->where('id_pengguna', '!=', $id_pengguna) // Menampilkan produk yang tidak dimiliki oleh pengguna yang login
            ->where('id_kategori', '==', $id) // Menampilkan produk yang tidak dimiliki oleh pengguna yang login
            ->paginate(30);

        // dump($data);
        // return view('penyediajasa.produk', compact('data'));
        return view('customer.dashboard_customerkategori', compact('data', 'kategori'));
    }

    public function cus_detailproduk($id)
    {
        $produk = Produk::with('kategori')->where('id', $id)->first();
        $pengguna = Pengguna::with('kategori')->where('id', $produk->id_pengguna)->first();
        $keahlian = Keahlian::where('id_pengguna', $pengguna->id)->get();
        $silver = PaketProduk::where('id_produk', $id)->where('paket', 'silver')->first();
        $gold = PaketProduk::where('id_produk', $id)->where('paket', 'gold')->first();
        $diamond = PaketProduk::where('id_produk', $id)->where('paket', 'diamond')->first();

        return view('customer.detail_produk', compact('produk', 'pengguna', 'silver', 'gold', 'diamond', 'keahlian'));
    }


    public function checkout($id)
    {

        \Midtrans\Config::$serverKey = config('midtrans.serverKey');
        \Midtrans\Config::$isProduction = config('midtrans.isProduction');
        \Midtrans\Config::$isSanitized = config('midtrans.isSanitized');
        \Midtrans\Config::$is3ds = config('midtrans.is3ds');
        // Set your Merchant Server Key
        // \Midtrans\Config::$serverKey = 'SB-Mid-server-uW80LNTtqEw17-UbwSH4BLZl';
        // // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        // \Midtrans\Config::$isProduction = false;
        // // Set sanitization on (default)
        // \Midtrans\Config::$isSanitized = true;
        // // Set 3DS transaction for credit card to true
        // \Midtrans\Config::$is3ds = true;

        $paket_produk = PaketProduk::with('produk')->where('id', $id)->first();
        $sepuluh_persen = $paket_produk->harga * 0.10;
        // Menghitung 10% dari harga
        $biaya_admin = 500;
        $total_harga = $paket_produk->harga + $sepuluh_persen + $biaya_admin;

        // dump( "10% dari harga adalah: Rp " . number_format($sepuluh_persen));
        // dump($biaya_admin);
        // $total_harga = $total_harga + $biaya_admin;
        $transactionDetails = [
            'order_id' => uniqid(), // Order ID sementara, bisa UUID atau random unique string
            'gross_amount' => $total_harga, // Jumlah yang akan dibayar (misal dari cart)
        ];
        $customer = Pengguna::where('id', auth()->user()->id)->first();
        $customerDetails = [
            'first_name' => $customer->nama,
            // 'last_name' => 'Doe',
            'email' => auth()->user()->email,
            'phone' => $customer->notelp,
        ];

        // Customer info
        // $pengguna
        // $customerDetails = [
        //     'first_name' => 'John',
        //     'last_name' => 'Doe',
        //     'email' => 'john.doe@example.com',
        //     'phone' => '08123456789',
        // ];

        // Buat parameter yang akan dikirim ke Midtrans untuk Snap Token
        $transaction = [
            'transaction_details' => $transactionDetails,
            'customer_details' => $customerDetails,
        ];

        // Request token dari Midtrans
        $snap_token = Snap::getSnapToken($transaction);

        return view('customer.checkout', compact('snap_token', 'paket_produk', 'total_harga', 'sepuluh_persen', 'biaya_admin'));
    }

    public function checkoutact(Request $request)
    {
        // Validasi data yang masuk
        $validatedData = $request->validate([
            'id_paketproduk' => 'required|exists:paket_produks,id',
            'tgl_awal' => 'required|date',
            'tgl_akhir' => 'required|date|after_or_equal:tgl_awal',
            'produk' => 'required|string',
            'paket' => 'required|string',
            'lama_hari' => 'required|integer',
            'deskripsi' => 'required|string',
            'total_harga' => 'required|integer',
            'metode' => 'required|string',
            'snap_token' => 'nullable|string',
        ]);

        try {
            // Simpan data transaksi
            $transaksi = new Transaksi();
            $transaksi->id_pengguna = auth()->user()->pengguna->id;
            $transaksi->tgl_awal = $request['tgl_awal'];
            $transaksi->tgl_akhir = $request['tgl_akhir'];
            $transaksi->total_harga = $request['total_harga'];
            $transaksi->biaya_admin = $request['biaya_admin'] ?? 0; // Default ke 0 jika tidak ada biaya admin
            $transaksi->metode = $request['metode'];
            $transaksi->snap_token = $request['snap_token'];
            $transaksi->status = 'Sudah bayar';

            $transaksi->save();

            // Mengambil data paket produk
            $paket_produk = PaketProduk::with('produk')->findOrFail($request['id_paketproduk']);
            $produk = $paket_produk->produk;
            $gambar = $produk->gambar;
            $asal = public_path('produk/' . $gambar);
            $tujuan = public_path('produk_pesan/' . $gambar);

            // Buat direktori tujuan jika belum ada
            if (!file_exists(public_path('produk_pesan/'))) {
                mkdir(public_path('produk_pesan'), 0777, true);
            }

            // Cek dan salin gambar
            if (file_exists($asal) && is_file($asal)) {
                // Salin gambar ke direktori tujuan
                if (copy($asal, $tujuan)) {
                    // Gambar berhasil disalin
                    // Simpan detail transaksi
                    $detail_transaksi = new detail_transaksi();
                    $detail_transaksi->id_transaksi = $transaksi->id;
                    $detail_transaksi->id_paket = $paket_produk->id;
                    $detail_transaksi->id_owner = $paket_produk->produk->id_pengguna;
                    $detail_transaksi->id_kategori = $paket_produk->produk->id_kategori;
                    $detail_transaksi->paket = $paket_produk->paket;
                    $detail_transaksi->produk = $paket_produk->produk->nama;
                    $detail_transaksi->gambar = $gambar; // Simpan nama file gambar
                    $detail_transaksi->lama_hari = $request['lama_hari'];
                    $detail_transaksi->deskripsi = $request['deskripsi'];
                    $detail_transaksi->save();
                } else {
                    throw new \Exception('Gagal menyalin gambar ke direktori tujuan.');
                }
            } else {
                return response()->json(['error' => 'Gambar produk tidak ditemukan.'], 404);
            }

            return response()->json(['message' => 'Transaksi berhasil disimpan!']);
        } catch (\Illuminate\Database\QueryException $e) {
            // Penanganan kesalahan yang terkait dengan database
            \Log::error('Database Error:', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            return response()->json([
                'error' => 'Kesalahan database terjadi. Silakan coba lagi nanti.',
                'message' => $e->getMessage(),
            ], 500);
        } catch (\Exception $e) {
            // Penanganan kesalahan umum
            \Log::error('General Error:', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            return response()->json([
                'error' => 'Terjadi kesalahan saat memproses transaksi.',
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ], 500);
        }
    }




    public function halaman_rating_semua()
    {

        $penggunaId = Auth::user()->id; // Mengambil id pengguna yang sedang login

        $transaksis = Transaksi::with(['rating', 'detailTransaksi'])
            ->where('id_pengguna', $penggunaId)
            ->where('status', 'Selesai') // Filter berdasarkan pengguna yang login
            ->whereDoesntHave('rating') // Menampilkan transaksi yang tidak memiliki rating
            ->get();
        return view('customer.halaman_rating_semua', compact('transaksis'));
    }

    public function ratingact(Request $request)
    {
        if ($request->hasFile('gambar')) {
            $validator = Validator::make($request->all(), [
                'ulasan' => 'required|string|max:255',

                // 'alamat' => 'required', //validasi alamat
                'rating' => 'required|numeric', //validasi no hp supaya angka ajaa
                //validasi no hp supaya angka ajaa
                'id_transaksi' => 'required|exists:transaksis,id',


                'foto' => 'required|mimes:jpg,png,jpeg|max:10000',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'ulasan' => 'required|string|max:255',
                'id_transaksi' => 'required|exists:transaksis,id',
                // 'alamat' => 'required', //validasi alamat
                'rating' => 'required|numeric', //validasi no hp supaya angka ajaa
                //validasi no hp supaya angka ajaa


                // 'foto' => 'required|mimes:jpg,png,jpeg|max:10000',
            ]);
        }



        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            Alert::error($messages)->flash();
            return back()->withErrors($validator)->withInput();
        }

        $ulasan = $request->ulasan;
        $rating = $request->rating;
        $data = new Raiting();
        $data->ulasan = $ulasan;
        $data->rating = $rating;
        $data->id_transaksi = $request->id_transaksi;
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/ulasan'), $fileName);
            $gambar = $fileName;
        } else {
            $gambar = null;
        }

        $data->file = $gambar;
        $data->save();
        Alert::success('Success', 'Berhasil raiting data')->flash();
        return redirect()->route('halaman_ratingsemua');


    }
}
