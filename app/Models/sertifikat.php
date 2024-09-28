<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sertifikat extends Model
{
    use HasFactory;
    protected $table = 'sertifikats';
    protected $fillable = ['sertif', 'id_pengguna'];
    public function pengguna(){
        return $this->belongsTo(Pengguna::class, 'id_pengguna');
    }
}
