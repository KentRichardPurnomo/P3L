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
        $barangs = Barang::where('status', 'tersedia')->get();
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
            'kategori_id'   => $barang->kategori_id ?? null,
            'deskripsi'     => $barang->deskripsi ?? null,
            'tanggal_donasi'=> Carbon::now(),
        ]);

        // Ubah status barang
        $barang->status = 'didonasikan';
        $barang->save();
        $requestDonasi->delete();

        return redirect()->route('owner.histori')->with('success', 'Barang berhasil dialokasikan!');
    }
}
