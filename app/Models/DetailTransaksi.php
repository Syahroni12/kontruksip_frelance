<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi  extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'detail_transaksis';
    protected $fillable = [
        'produk',
        'paket',
        'lama_hari',
        'deskripsi',
        'harga',
        'gambar',
        'id_kategori',
        'id_owner',
        'id_transaksi',
        'id_paket'
    ];


    public function paket()
    {
        return $this->belongsTo(PaketProduk::class, 'id_paket', 'id');
    }
    public function owner()
    {
        return $this->belongsTo(Pengguna::class, 'id_owner', 'id');
    }
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class,'id_transaksi', 'id');
    }
    public function Pengguna()
    {
        return $this->belongsTo(Pengguna::class,'id_owner', 'id');
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriJasa::class, 'id_kategori', 'id');
    }
}
