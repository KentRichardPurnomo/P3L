<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Barang;
use Carbon\Carbon;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Barang::create([
            'kategori_id' => 1,
            'nama' => 'Kipas Angin Portable',
            'deskripsi' => 'Kipas hemat listrik, ringan, cocok untuk kamar.',
            'harga' => 125000,
            'thumbnail' => '1.jpg',
            'foto_lain' => json_encode(['1_1.jpg', '1_2.jpg']),
            'terjual' => false,
            'garansi_berlaku_hingga' => Carbon::now()->addDays(60)
        ]);

        Barang::create([
            'kategori_id' => 1,
            'nama' => 'Headset Bluetooth',
            'deskripsi' => 'Headset wireless baterai tahan lama.',
            'harga' => 175000,
            'thumbnail' => '2.jpg',
            'foto_lain' => json_encode(['2_1.jpg', '2_2.jpg']),
            'terjual' => false,
            'garansi_berlaku_hingga' => Carbon::now()->addDays(15)
        ]);

        Barang::create([
            'kategori_id' => 2,
            'nama' => 'Kaos Pria Polos',
            'deskripsi' => 'Kaos pria bahan adem dan ringan.',
            'harga' => 50000,
            'thumbnail' => '3.jpg',
            'foto_lain' => json_encode(['3_1.jpg']),
            'terjual' => false,
            'garansi_berlaku_hingga' => null
        ]);

        Barang::create([
            'kategori_id' => 3,
            'nama' => 'Meja Belajar Minimalis',
            'deskripsi' => 'Meja belajar ukuran kecil untuk ruangan sempit.',
            'harga' => 225000,
            'thumbnail' => '4.jpg',
            'foto_lain' => json_encode(['4_1.jpg', '4_2.jpg']),
            'terjual' => false,
            'garansi_berlaku_hingga' => Carbon::now()->subDays(5) // Sudah habis
        ]);

        Barang::create([
            'kategori_id' => 2,
            'nama' => 'Kacamata Fashion Wanita',
            'deskripsi' => 'Kacamata UV protection cocok untuk gaya casual.',
            'harga' => 89000,
            'thumbnail' => '5.jpg',
            'foto_lain' => json_encode(['5_1.jpg']),
            'terjual' => true,
            'garansi_berlaku_hingga' => Carbon::now()->addDays(30)
        ]);

        Barang::create([
    'kategori_id' => 4,
    'nama' => 'Helm Motor Retro',
    'deskripsi' => 'Helm klasik dengan kaca pelindung, cocok untuk motor tua.',
    'harga' => 110000,
    'thumbnail' => '6.jpg',
    'foto_lain' => json_encode(['6_1.jpg', '6_2.jpg']),
    'terjual' => false,
    'garansi_berlaku_hingga' => Carbon::now()->addDays(90)
]);

Barang::create([
    'kategori_id' => 5,
    'nama' => 'Stroller Lipat Bayi',
    'deskripsi' => 'Stroller bekas ringan dan bisa dilipat.',
    'harga' => 300000,
    'thumbnail' => '7.jpg',
    'foto_lain' => json_encode(['7_1.jpg']),
    'terjual' => false,
    'garansi_berlaku_hingga' => Carbon::now()->addDays(60)
]);

Barang::create([
    'kategori_id' => 6,
    'nama' => 'Rakets Badminton',
    'deskripsi' => 'Raket ringan, bekas latihan bulu tangkis.',
    'harga' => 85000,
    'thumbnail' => '8.jpg',
    'foto_lain' => json_encode(['8_1.jpg', '8_2.jpg']),
    'terjual' => false,
    'garansi_berlaku_hingga' => null
]);

Barang::create([
    'kategori_id' => 7,
    'nama' => 'Set Alat Tulis Sekolah',
    'deskripsi' => 'Pensil, penghapus, dan pena bekas pakai namun masih bagus.',
    'harga' => 25000,
    'thumbnail' => '9.jpg',
    'foto_lain' => json_encode(['9_1.jpg']),
    'terjual' => false,
    'garansi_berlaku_hingga' => null
]);

Barang::create([
    'kategori_id' => 8,
    'nama' => 'Jam Dinding Antik',
    'deskripsi' => 'Jam dinding tahun 80-an, masih berfungsi.',
    'harga' => 175000,
    'thumbnail' => '10.jpg',
    'foto_lain' => json_encode(['10_1.jpg']),
    'terjual' => true,
    'garansi_berlaku_hingga' => null
]);

Barang::create([
    'kategori_id' => 9,
    'nama' => 'Gitar Akustik Second',
    'deskripsi' => 'Gitar masih berfungsi baik, cocok untuk pemula.',
    'harga' => 200000,
    'thumbnail' => '11.jpg',
    'foto_lain' => json_encode(['11_1.jpg']),
    'terjual' => false,
    'garansi_berlaku_hingga' => Carbon::now()->addDays(10)
]);

Barang::create([
    'kategori_id' => 10,
    'nama' => 'Boneka Panda Jumbo',
    'deskripsi' => 'Boneka ukuran besar, bahan lembut, bekas hadiah.',
    'harga' => 95000,
    'thumbnail' => '12.jpg',
    'foto_lain' => json_encode(['12_1.jpg']),
    'terjual' => false,
    'garansi_berlaku_hingga' => null
]);

Barang::create([
    'kategori_id' => 11,
    'nama' => 'Konsol Game PS2',
    'deskripsi' => 'PlayStation 2 lengkap dengan 2 stik dan beberapa CD.',
    'harga' => 450000,
    'thumbnail' => '13.jpg',
    'foto_lain' => json_encode(['13_1.jpg', '13_2.jpg']),
    'terjual' => false,
    'garansi_berlaku_hingga' => null
]);

Barang::create([
    'kategori_id' => 12,
    'nama' => 'Paket Pot Tanaman Kecil',
    'deskripsi' => 'Pot kecil cocok untuk tanaman hias indoor.',
    'harga' => 40000,
    'thumbnail' => '14.jpg',
    'foto_lain' => json_encode(['14_1.jpg']),
    'terjual' => false,
    'garansi_berlaku_hingga' => null
]);

Barang::create([
    'kategori_id' => 1,
    'nama' => 'Powerbank 10000mAh',
    'deskripsi' => 'Powerbank kondisi bekas, daya tahan masih bagus.',
    'harga' => 80000,
    'thumbnail' => '15.jpg',
    'foto_lain' => json_encode(['15_1.jpg']),
    'terjual' => true,
    'garansi_berlaku_hingga' => Carbon::now()->addDays(20)
]);
    }
}
