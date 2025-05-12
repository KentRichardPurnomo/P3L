<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use App\Models\Pegawai;

class Pegawai extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'username', 'nama_lengkap', 'tanggal_lahir', 'password', 'id_jabatan', 'alamat_rumah'
    ];

    protected $hidden = [
        'password',
    ];

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }
}
