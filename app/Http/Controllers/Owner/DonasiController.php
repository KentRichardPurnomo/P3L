<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DonasiBarang;
use App\Models\Organisasi;
use App\Models\Barang;

class DonasiController extends Controller
{
    public function edit($id)
    {   
        $donasi = DonasiBarang::with(['organisasi', 'barang'])->findOrFail($id);
        $organisasis = Organisasi::all();
        $barang = $donasi->barang;

        return view('owner.donasi.edit', compact('donasi', 'organisasis', 'barang'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_penerima' => 'required|string|max:100',
            'tanggal_donasi' => 'required|date',
            'status_barang' => 'required|string'
        ]);

        $donasi = DonasiBarang::findOrFail($id);
        $barang = Barang::where('nama', $donasi->nama_barang)->first();

        $donasi->update([
            'nama_penerima' => $request->nama_penerima,
            'tanggal_donasi' => $request->tanggal_donasi,
        ]);

        if ($donasi->barang) {
            $donasi->barang->status = $request->status_barang;
            $donasi->barang->save();
        }

        return redirect()->route('owner.histori')->with('success', 'Donasi berhasil diperbarui!');
    }

}
