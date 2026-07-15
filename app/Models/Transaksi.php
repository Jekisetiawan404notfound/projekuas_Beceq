<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table      = 'transaksis';
    protected $primaryKey = 'id_transaksi';
    public    $timestamps = false;

    protected $fillable = [
        'id_pelanggan',
        'id_admin',
        'tgl_transaksi',
        'total_bayar',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_admin', 'id_admin');
    }

    public function detail_transaksis()
    {
        return $this->hasMany(Detail_transaksi::class, 'id_transaksi', 'id_transaksi');
    }
}
