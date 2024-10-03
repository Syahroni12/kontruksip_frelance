<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    protected $table = "produks";
    protected $guarded = 'id';

    public function kategori()
    {
        return $this->belongsTo(KategoriJasa::class, 'id_kategori');
    }
    public function paket() {
        return $this->hasMany(PaketProduk::class, 'id_user');
    }
}
