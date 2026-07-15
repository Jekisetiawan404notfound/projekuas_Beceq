<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detail_transaksi extends Model
{
    protected $table      = 'detail_transaksis';
    protected $primaryKey = 'id_detail';
    public    $timestamps = false;

    protected $fillable = [
        'id_transaksi',
        'id_mobil',
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
}