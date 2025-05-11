<?php

namespace App\Http\Controllers\Penitip;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'harga' => 'required|numeric',
            'deskripsi' => 'nullable|string',
            'kategori_id' => 'required|exists:kategoris,id',
            'thumbnail' => 'required|image',
        ]);

        $barang = new \App\Models\Barang();
        $barang->nama = $request->nama;
        $barang->harga = $request->harga;
        $barang->deskripsi = $request->deskripsi;
        $barang->kategori_id = $request->kategori_id;
        $barang->penitip_id = Auth::guard('penitip')->id(); // ⬅️ baris penting

        // Simpan thumbnail ke storage/public/images/barang/{id}
        $barang->save(); // simpan dulu untuk mendapatkan ID

        $thumbnailPath = $request->file('thumbnail')->storeAs(
            'public/images/barang/' . $barang->id,
            'thumb.jpg'
        );
        $barang->thumbnail = 'thumb.jpg';
        $barang->save();

        return redirect()->route('penitip.dashboard')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function show($id)
    {
        $barang = \App\Models\Barang::with('kategori')->findOrFail($id);

        if ($barang->penitip_id !== Auth::guard('penitip')->id()) {
            abort(403, 'Barang ini bukan milik Anda.');
        }

        return view('penitip.barang-show', compact('barang'));
    }
}
