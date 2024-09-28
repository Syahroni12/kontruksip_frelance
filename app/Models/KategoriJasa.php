<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriJasa extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'kategori_jasas';

    public function kategorijasa_users()
    {
        return $this->hasMany(kategorijasa_user::class,'id_kategorijasa');
    }
}
