<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengguna extends Model
{
    use HasFactory;
protected $table="penggunas";
protected $guarded='id';





    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    public function sertif()
    {
        return $this->hasMany(sertifikat::class, 'id_user');
    }
    public function keahlian()
    {
        return $this->hasMany(Keahlian::class, 'id_user');
    }
    public function produk()
    {
        return $this->hasMany(Produk::class, 'id_pengguna','id');
    }
    public function transaksi() {
        return $this->hasMany(Transaksi::class, 'id_pengguna', 'id');
    }
}
