<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RedeemPoin extends Model
{
    use HasFactory;

    protected $fillable = [
        'pembeli_id',
        'merchandise_id',
        'status',
        'tanggal_ambil',
    ];

    public function pembeli()
    {
        return $this->belongsTo(Pembeli::class);
    }

    public function merchandise()
    {
        return $this->belongsTo(Merchandise::class);
    }
}
