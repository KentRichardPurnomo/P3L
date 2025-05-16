<?php

namespace App\Http\Controllers\Penitip;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Pembeli;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;

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

    public function riwayat($id)
    {
        $barang = Barang::findOrFail($id);

        // Ambil transaksi terakhir berdasarkan relasi yang benar
        $detail = $barang->detailTransaksis()->latest()->first();

        $pembeli = null;
        $poinPembeli = 0;

        if ($detail && $detail->transaksi && $detail->transaksi->pembeli) {
            $pembeli = $detail->transaksi->pembeli;
            $poinPembeli = $pembeli->poin;
        }

        $komisi = $barang->harga * 0.1;

        return view('penitip.penitip_riwayat', compact('barang', 'pembeli', 'poinPembeli', 'komisi'));
    }

    public function barangTidakLaku()
{
    $penitipId = Auth::guard('penitip')->id();

    $barangTidakLaku = Barang::with('kategori')
        ->where('penitip_id', $penitipId)
        ->where('terjual', false)
        ->get();

    return view('penitip.barang-tidak-laku', compact('barangTidakLaku'));
}

}
