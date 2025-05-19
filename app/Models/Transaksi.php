<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'pembeli_id',
        'tanggal',
        'total',
        'status',
        'alamat_pengiriman_id',
        'tipe_pengiriman',
        'poin_ditukar',
        'potongan',
        'bukti_transfer',
        'deadline_pembayaran',
    ];

    public function pembeli()
    {
        return $this->belongsTo(\App\Models\Pembeli::class);
    }

    public function detail()
    {
        return $this->hasMany(\App\Models\DetailTransaksi::class);
    }

    public function alamat()
    {
        return $this->belongsTo(AlamatPembeli::class, 'alamat_pengiriman_id');
    }
}
