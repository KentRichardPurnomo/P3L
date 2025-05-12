<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\Barang;

class KategoriController extends Controller
{
    // Menampilkan barang berdasarkan kategori
    public function show($id)
    {
        $kategori = Kategori::with('barangs')->findOrFail($id);
        return view('kategori.show', compact('kategori'));
    }

    // Menampilkan 10 barang terbaru (fitur 'Baru Masuk')
    public function baruMasuk()
    {
        $kategori = new \stdClass(); // objek kosong untuk meniru model Kategori
        $kategori->nama = 'Baru Masuk';
        $kategori->barangs = Barang::orderBy('created_at', 'desc')->take(10)->get();

        return view('kategori.show', compact('kategori'));
    }
}
