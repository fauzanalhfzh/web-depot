<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pelanggan extends Authenticatable
{
    use Notifiable, HasFactory, SoftDeletes;

    protected $table = 'pelanggan';

    protected $fillable = [
        'nama_pelanggan',
        'kontak_pelanggan',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }
}
