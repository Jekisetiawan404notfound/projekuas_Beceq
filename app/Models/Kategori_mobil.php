<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori_mobil extends Model
{
    protected $table = 'kategori_mobils';
    protected $primaryKey = 'id_kategori';
    public $timestamps = false;

    protected $fillable = [
        'nama_kategori',
    ];

    public function mobils()
    {
        return $this->hasMany(Mobil::class, 'id_kategori', 'id_kategori');
    }
}