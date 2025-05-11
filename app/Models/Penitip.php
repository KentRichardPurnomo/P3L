<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Penitip extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'username',
        'email',
        'no_telp',
        'password',
        'profile_picture',
        'plaintext_password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function barangs()
    {
        return $this->hasMany(\App\Models\Barang::class);
    }
}
