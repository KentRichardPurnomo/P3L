<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Owner extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guard = 'owner';

    protected $fillable = [
        'username', 'email', 'nama_lengkap', 'no_telp', 'tanggal_lahir', 'alamat_rumah', 'password',
    ];

    protected $hidden = [
        'password',
    ];
}
