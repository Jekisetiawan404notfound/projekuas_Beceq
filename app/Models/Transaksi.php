<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = [
        'pelanggan_id',
        'admin_id',
        'tgl_transaksi',
        'total_bayar',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function detail_transaksis()
    {
        return $this->hasMany(Detail_transaksi::class);
    }
}
