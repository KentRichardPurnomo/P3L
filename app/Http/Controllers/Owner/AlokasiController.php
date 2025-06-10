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
        $barangs = Barang::where('status', 'barang untuk donasi')->get();
        return view('owner.alokasi', compact('requestDonasi', 'barangs'));
    }

    public function store(Request $request, RequestDonasi $requestDonasi)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'nama_penerima' => 'required|string|max:100'
        ]);

        $barang = Barang::findOrFail($request->barang_id);

        DonasiBarang::create([
            'organisasi_id'  => $requestDonasi->organisasi_id,
            'barang_id'      => $barang->id,
            'nama_penerima'  => $request->nama_penerima,
            'nama_barang'    => $barang->nama,
            'kategori_id'    => $barang->kategori_id,
            'deskripsi'      => $barang->deskripsi,
            'tanggal_donasi' => now(),
        ]);

        $barang->status = 'didonasikan';
        $barang->save();
        $requestDonasi->delete();

        if ($barang->penitip_id && $barang->harga) {
            $penitip = \App\Models\Penitip::find($barang->penitip_id);
            if ($penitip) {
                $poin = floor($barang->harga / 10000);
                $penitip->increment('poin', $poin);
            }
        }

        return redirect()->route('owner.histori')->with('success', 'Barang berhasil dialokasikan dan poin penitip ditambahkan!');
    }

}
