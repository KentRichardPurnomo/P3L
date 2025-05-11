<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Barang extends Model
{
    use HasFactory;
    protected $fillable = [
        'kategori_id',
        'nama',
        'deskripsi',
        'harga',
        'thumbnail',
        'foto_lain',
        'garansi_berlaku_hingga',
        'terjual',
    ];

    protected $casts = [
        'foto_lain' => 'array',
        'garansi_berlaku_hingga' => 'date',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function diskusis()
    {
        return $this->hasMany(Diskusi::class);
    }

    // Opsional helper untuk cek status garansi
    public function isGaransiAktif()
    {
        return $this->garansi_berlaku_hingga && $this->garansi_berlaku_hingga->isFuture();
    }

    public function penitip()
    {
        return $this->belongsTo(\App\Models\Penitip::class);
    }
}


