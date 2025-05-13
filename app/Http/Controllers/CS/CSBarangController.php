<?php

namespace App\Http\Controllers\CS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Penitip;

class CSBarangController extends Controller
{
    public function create()
    {
        $penitips = Penitip::all();
        return view('cs.csbarangcreate', compact('penitips'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'deskripsi' => 'nullable|string',
            'kategori_id' => 'required|exists:kategoris,id',
            'penitip_id' => 'required|exists:penitips,id',
            'thumbnail' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $barang = new Barang($request->only(['nama', 'harga', 'deskripsi', 'kategori_id', 'penitip_id']));
        $barang->terjual = false;
        $barang->save();

        // Simpan thumbnail
        $path = $request->file('thumbnail')->store("barang/{$barang->id}", 'public');
        $barang->thumbnail = str_replace("barang/{$barang->id}/", '', $path);
        $barang->save();

        return redirect()->route('cs.barang.semua')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function show($id)
    {
        $barang = Barang::with('penitip', 'kategori')->findOrFail($id);
        return view('cs.csbarangshow', compact('barang'));
    }

    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        $penitips = \App\Models\Penitip::all();
        $kategoris = \App\Models\Kategori::all();

        return view('cs.csbarangedit', compact('barang', 'penitips', 'kategoris'));
    }

    public function update(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'deskripsi' => 'nullable|string',
            'kategori_id' => 'required|exists:kategoris,id',
            'penitip_id' => 'required|exists:penitips,id',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'foto_lain.*' => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $barang->update($request->only(['nama', 'harga', 'deskripsi', 'kategori_id', 'penitip_id']));

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store("barang/{$barang->id}", 'public');
            $barang->thumbnail = str_replace("barang/{$barang->id}/", '', $path);
            $barang->save();
        }

        if ($request->hasFile('foto_lain')) {
            $fotoList = [];

            foreach ($request->file('foto_lain') as $foto) {
                $path = $foto->store("barang/{$barang->id}", 'public');
                $filename = str_replace("barang/{$barang->id}/", '', $path);
                $fotoList[] = $filename;
            }

            // Gabungkan dengan yang lama jika ada
            $existing = json_decode($barang->foto_lain ?? '[]', true);
            $barang->foto_lain = json_encode(array_merge($existing, $fotoList));
            $barang->save();
        }

        return redirect()->route('cs.barang.show', $barang->id)->with('success', 'Barang berhasil diperbarui.');
    }
}
