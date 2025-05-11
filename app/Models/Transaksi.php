<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    public function pembeli()
    {
        return $this->belongsTo(Pembeli::class);
    }

    public function detail()
    {
        return $this->hasMany(DetailTransaksi::class);
    }
}
