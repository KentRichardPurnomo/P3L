<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RequestDonasi;
use App\Models\DonasiBarang;
use App\Models\Barang;
use Carbon\Carbon;

class AlokasiController extends Controller
{
    public function form(RequestDonasi $requestDonasi)
    {
        $barangs = Barang::where('status', 'donasi')->get();
        return view('owner.alokasi', compact('requestDonasi', 'barangs'));
    }

    public function store(Request $request, RequestDonasi $requestDonasi)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id'
        ]);

        $barang = Barang::findOrFail($request->barang_id);

        // Simpan ke donasi_barangs
        DonasiBarang::create([
            'organisasi_id' => $requestDonasi->organisasi_id,
            'nama_barang'   => $barang->nama,
            'kategori_id'   => $barang->kategori_id,
            'deskripsi'     => $barang->deskripsi,
            'tanggal_donasi'=> now(),
        ]);

        // Ubah status barang
        $barang->status = 'didonasikan';
        $barang->save();

        // Hapus request donasi
        $requestDonasi->delete();

        // ✅ Tambah poin untuk penitip jika ada
        if ($barang->penitip_id) {
            $penitip = \App\Models\Penitip::find($barang->penitip_id);
            if ($penitip) {
                $penitip->increment('poin', 1);
            }
        }

        return redirect()->route('owner.histori')->with('success', 'Barang berhasil dialokasikan dan poin penitip ditambahkan!');
    }
}
