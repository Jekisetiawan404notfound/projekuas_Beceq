<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mobil extends Model
{
    protected $table = 'mobils';
    protected $fillable = [
        'kategori_id',
        'merek',
        'model',
        'harga',
        'stok'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori_mobil::class, 'kategori_id');
    }

    public function detail_transaksis()
    {
        return $this->hasMany(Detail_transaksi::class);
    }   
    
}
