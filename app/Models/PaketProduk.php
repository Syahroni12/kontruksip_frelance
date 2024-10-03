<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaketProduk extends Model
{
    use HasFactory;
    protected $table = "paket_produks";
    protected $guarded = 'id';

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_kategori');
    }

}
