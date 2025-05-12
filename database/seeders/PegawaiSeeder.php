<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pegawais')->insert([
            [
                'username' => 'owner',
                'nama_lengkap' => 'Owner ReuseMart',
                'tanggal_lahir' => '1990-01-01',
                'password' => Hash::make('owner'),
                'jabatan_id' => 1, // Owner
                'alamat_rumah' => 'Jl. Utama No.1, Jakarta',
            ],
            [
                'username' => 'admin',
                'nama_lengkap' => 'Admin ReuseMart',
                'tanggal_lahir' => '1995-02-15',
                'password' => Hash::make('admin'),
                'jabatan_id' => 2, // Admin
                'alamat_rumah' => 'Jl. Kedua No.2, Bandung',
            ],
        ]);
    }
}
