<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pembeli extends Authenticatable
{

    use Notifiable;

    protected $fillable = [
        'username',
        'email',
        'no_telp',
        'password',
        'plaintext_password',
        'profile_picture',
        'default_alamat_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function alamat()
    {
        return $this->hasMany(AlamatPembeli::class);
    }

    public function defaultAlamat()
    {
        return $this->belongsTo(AlamatPembeli::class, 'default_alamat_id');
    }

    public function transaksis()
    {
        return $this->hasMany(\App\Models\Transaksi::class);
    }

    public function diskusis()
    {
        return $this->hasMany(Diskusi::class, 'user_id');
    }
}
