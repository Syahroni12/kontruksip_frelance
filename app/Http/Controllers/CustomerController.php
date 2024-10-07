<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PaketProduk;
use App\Models\Pengguna;
use App\Models\Produk;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request) {
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
        return view('customer.dashboard_customer',compact('data'));
    }

    public function cus_detailproduk($id) {
        $produk= Produk::with('kategori')->where('id',$id)->first();
        $pengguna = Pengguna::with('kategori')->where('id',$produk->id_pengguna)->first();
        $silver = PaketProduk::where('id_produk', $id)->where('paket', 'silver')->first();
        $gold = PaketProduk::where('id_produk', $id)->where('paket', 'gold')->first();
        $diamond = PaketProduk::where('id_produk', $id)->where('paket', 'diamond')->first();

        return view('customer.detail_produk', compact('produk', 'pengguna', 'silver', 'gold', 'diamond'));

    }
}
