<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'chats';

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi');
    }

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_penerima');
    }
}
