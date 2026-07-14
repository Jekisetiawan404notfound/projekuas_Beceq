<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detail_transaksi extends Model
{
    protected $table = 'detail_transaksis';
    protected $primaryKey = 'id_detail';
    public $timestamps = false;

    protected $fillable = [
        'id_transaksi',
        'transaksi_id', // support both
        'id_mobil',
        'mobil_id', // support both
        'jumlah_beli',
        'subtotal',
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi', 'id_transaksi');
    }

    public function mobil()
    {
        return $this->belongsTo(Mobil::class, 'id_mobil', 'id_mobil');
    }

    // Alias Accessors & Mutators
    public function getTransaksiIdAttribute()
    {
        return $this->attributes['id_transaksi'] ?? null;
    }

    public function setTransaksiIdAttribute($value)
    {
        $this->attributes['id_transaksi'] = $value;
    }

    public function getMobilIdAttribute()
    {
        return $this->attributes['id_mobil'] ?? null;
    }

    public function setMobilIdAttribute($value)
    {
        $this->attributes['id_mobil'] = $value;
    }
}