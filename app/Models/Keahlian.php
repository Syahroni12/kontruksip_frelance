<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keahlian extends Model
{
    use HasFactory;
    protected $table = 'keahlians';

    protected $fillable = [
        'keahlian',
        'id_pengguna',
    ];

    public function pengguna(){
        return $this->belongsTo(Pengguna::class, 'id_pengguna');
    }
}
