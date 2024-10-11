<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detail_transaksi extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'detail_transaksis';


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
        return $this->belongsTo(Transaksi::class);
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriJasa::class, 'id_kategori', 'id');
    }
}
