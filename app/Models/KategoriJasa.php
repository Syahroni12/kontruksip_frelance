<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriJasa extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'kategori_jasas';

    public function Pengguna()
    {
        return $this->hasMany(Pengguna::class,'id_kategori','id');
    }
    public function produk()
    {
        return $this->hasMany(Produk::class,'id_kategori','id');
    }
}
