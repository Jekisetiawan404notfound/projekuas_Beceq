<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admins';
    protected $fillable = [
        'username',
        'password'
    ];

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }   
}
