<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonasiBarang extends Model
{
    use HasFactory;

    protected $fillable = [
        'organisasi_id', 'nama_barang', 'kategori', 'deskripsi', 'tanggal_donasi'
    ];

    public function organisasi()
    {
        return $this->belongsTo(Organisasi::class);
    }

    public function kategori()
    {
        return $this->belongsTo(\App\Models\Kategori::class, 'kategori_id');
    }
    }
