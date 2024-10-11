<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'transaksis';


    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id');
    }

    public function PaketProduk()
    {
        return $this->belongsTo(PaketProduk::class, 'id_produk', 'id');
    }
    public function Raiting(){
        return $this->hasMany(Raiting::class, 'id_transaksi', 'id');
    }
}
