<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produk extends Model
{
    use SoftDeletes;

    protected $table = 'produk';

    protected $guarded = [];

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }
}
