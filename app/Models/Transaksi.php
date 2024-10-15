<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'transaksis';

    // Pastikan bagian ini tidak dikomentari
    protected $fillable = [
        'id_pengguna',
        'tgl_awal',
        'tgl_akhir',
        'biaya_admin',
        'total_harga',
        'metode',
        'snap_token',
        'status'  // Pastikan 'status' bisa diisi (fillable)
    ];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id');
    }

    public function PaketProduk()
    {
        return $this->belongsTo(PaketProduk::class, 'id_produk', 'id');
    }

    public function rating()
    {
        return $this->hasOne(Raiting::class, 'id_transaksi', 'id');
    }

    public function Detail_transaksi()
    {
        return $this->hasOne(DetailTransaksi ::class, 'id_transaksi', 'id');
    }

    public function chat()
    {
        return $this->hasMany(Chat::class, 'id_transaksi', 'id');
    }
}
