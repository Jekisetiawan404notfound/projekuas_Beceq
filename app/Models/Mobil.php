<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mobil extends Model
{
    protected $table = 'mobils';
    protected $primaryKey = 'id_mobil';
    public $timestamps = false;

    protected $fillable = [
        'id_kategori',
        'kategori_id', // support both
        'merek',
        'model',
        'harga',
        'stok'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori_mobil::class, 'id_kategori', 'id_kategori');
    }

    public function detail_transaksis()
    {
        return $this->hasMany(Detail_transaksi::class, 'id_mobil', 'id_mobil');
    }

    // Alias Accessor & Mutator for kategori_id
    public function getKategoriIdAttribute()
    {
        return $this->attributes['id_kategori'] ?? null;
    }

    public function setKategoriIdAttribute($value)
    {
        $this->attributes['id_kategori'] = $value;
    }
}