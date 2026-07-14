<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = [
        'id_pelanggan',
        'pelanggan_id',
        'id_admin',
        'admin_id',
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

    // Alias Accessors & Mutators
    public function getPelangganIdAttribute()
    {
        return $this->attributes['id_pelanggan'] ?? null;
    }

    public function setPelangganIdAttribute($value)
    {
        $this->attributes['id_pelanggan'] = $value;
    }

    public function getAdminIdAttribute()
    {
        return $this->attributes['id_admin'] ?? null;
    }

    public function setAdminIdAttribute($value)
    {
        $this->attributes['id_admin'] = $value;
    }
}
