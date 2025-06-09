<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopSeller extends Model
{
    use HasFactory;
    
    protected $fillable = ['penitip_id', 'bulan', 'tahun', 'dibuat_oleh'];

    public function penitip()
    {
        return $this->belongsTo(Penitip::class);
    }

    public function admin()
    {
        return $this->belongsTo(Pegawai::class, 'dibuat_oleh');
    }
}
