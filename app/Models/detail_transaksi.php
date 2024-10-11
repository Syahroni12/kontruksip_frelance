<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detail_transaksi extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
protected $table = 'detail_transaksis';
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }
}
