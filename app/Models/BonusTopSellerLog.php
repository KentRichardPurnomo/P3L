<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BonusTopSellerLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'penitip_id',
        'bulan',
        'tahun',
        'jumlah_bonus',
        'dibuat_oleh',
    ];

    public function penitip()
    {
        return $this->belongsTo(Penitip::class);
    }

    public function admin()
    {
        return $this->belongsTo(Pegawai::class, 'dibuat_oleh');
    }
}
