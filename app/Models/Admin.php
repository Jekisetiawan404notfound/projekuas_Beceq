<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admins';
    protected $primaryKey = 'id_admin';
    public $timestamps = false;

    protected $fillable = [
        'username',
        'password'
    ];

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'id_admin', 'id_admin');
    }
}