<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kategorijasa_user extends Model
{
    use HasFactory;
    protected $guarded=['id'];
    public function kategorijasa(){
        return $this->belongsTo(KategoriJasa::class,'id_kategorijasa');
    }

    public function pengguna(){
        return $this->belongsTo(Pengguna::class,'id_pengguna');
    }
}
