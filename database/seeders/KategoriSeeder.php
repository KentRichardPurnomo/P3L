<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

DB::table('kategoris')->insert([
    ['nama' => 'Elektronik'],
    ['nama' => 'Fashion'],
    ['nama' => 'Furniture'],
    ['nama' => 'Automotive'],
    ['nama' => 'Bayi & Anak'],
    ['nama' => 'Hobi & Olahraga'],
    ['nama' => 'Buku & Alat Tulis'],
    ['nama' => 'Barang Antik & Koleksi'],
    ['nama' => 'Musik'],
    ['nama' => 'Mainan'],
    ['nama' => 'Game & Hobi'],
    ['nama' => 'Perkebunan'],
]);

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
    }
}
