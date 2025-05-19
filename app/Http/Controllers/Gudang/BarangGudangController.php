<?php

namespace App\Http\Controllers\Gudang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Penitip;
use Illuminate\Support\Facades\File;
use Barryvdh\DomPDF\Facade\Pdf;

class BarangGudangController extends Controller
{
    public function index(Request $request)
    {
        $pegawai = Auth::guard('pegawai')->user();
        $query = Barang::with(['kategori', 'penitip'])
            ->where('quality_check', $pegawai->id);

        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where('nama', 'like', '%' . $searchTerm . '%');
        }

        $barangs = $query->get();

        return view('gudang.barangIndex', compact('barangs'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        $penitips = Penitip::all();

        return view('gudang.barangCreate', compact('kategoris', 'penitips'));
    }

    public function store(Request $request)
    {
        $pegawai = Auth::guard('pegawai')->user();

        $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric',
            'thumbnail' => 'required|image|mimes:jpg,jpeg|max:20480',
            'foto_lain.*' => 'nullable|image|mimes:jpg,jpeg|max:20480',
            'punya_garansi' => 'required|in:0,1',
            'garansi_berlaku_hingga' => 'nullable|date',
            'penitip_id' => 'required|exists:penitips,id',
        ]);

        $garansi = $request->punya_garansi == 1 ? $request->garansi_berlaku_hingga : null;

        // 1. Simpan barang untuk dapat ID
        $barang = Barang::create([
            'kategori_id' => $request->kategori_id,
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'garansi_berlaku_hingga' => $garansi,
            'terjual' => false,
            'penitip_id' => $request->penitip_id,
            'quality_check' => $pegawai->id,
            'batas_waktu_titip' => now()->addMonth(),
            'thumbnail' => '',
            'foto_lain' => json_encode([]),
        ]);

        $id = $barang->id;
        $folder = public_path("images/barang/$id");

        if (!File::exists($folder)) {
            File::makeDirectory($folder, 0775, true);
        }

        // 2. Simpan thumbnail
        $thumbnailFile = $request->file('thumbnail');
        $thumbnailName = "{$id}.jpg";
        $thumbnailFile->move($folder, $thumbnailName);

        // 3. Simpan foto_lain[]
        $fotoLainPaths = [];
        if ($request->hasFile('foto_lain')) {
            $index = 1;
            foreach ($request->file('foto_lain') as $foto) {
                $fotoName = "{$id}_{$index}.jpg";
                $foto->move($folder, $fotoName);
                $fotoLainPaths[] = $fotoName;
                $index++;
            }
        }

        // 4. Update thumbnail dan foto_lain
        $barang->update([
            'thumbnail' => $thumbnailName,
            'foto_lain' => json_encode($fotoLainPaths),
        ]);

        // 5. Generate PDF Nota Penitipan
        $barang->load(['kategori', 'penitip']);
        $pdf = Pdf::loadView('gudang.nota_pdf', ['barang' => $barang]);

        $pdfPath = storage_path("app/public/notas/nota-barang-{$barang->id}.pdf");
        if (!File::exists(dirname($pdfPath))) {
            File::makeDirectory(dirname($pdfPath), 0755, true);
        }
        $pdf->save($pdfPath);

        return redirect()->route('gudang.barang.index')
            ->with('success', 'Barang berhasil ditambahkan dan nota penitipan telah dibuat.');
    }

    public function show($id)
    {
        $barang = Barang::with(['kategori', 'penitip'])->findOrFail($id);
        return view('gudang.barangShow', compact('barang'));
    }

    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        $kategoris = Kategori::all();
        $penitips = Penitip::all();

        return view('gudang.barangEdit', compact('barang', 'kategoris', 'penitips'));
    }

    public function update(Request $request, $id)
    {
        $pegawai = Auth::guard('pegawai')->user();
        $barang = Barang::findOrFail($id);

        $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg|max:20480',
            'foto_lain.*' => 'nullable|image|mimes:jpg,jpeg|max:20480',
            'punya_garansi' => 'required|in:0,1',
            'garansi_berlaku_hingga' => 'nullable|date',
            'penitip_id' => 'required|exists:penitips,id',
        ]);

        $garansi = $request->punya_garansi == 1 ? $request->garansi_berlaku_hingga : null;

        $folder = public_path("images/barang/{$barang->id}");
        if (!File::exists($folder)) {
            File::makeDirectory($folder, 0775, true);
        }

        if ($request->hasFile('thumbnail')) {
            $thumbnailName = "{$barang->id}.jpg";
            $request->file('thumbnail')->move($folder, $thumbnailName);
            $barang->thumbnail = $thumbnailName;
        }

        $fotoLainPaths = is_array(json_decode($barang->foto_lain, true)) ? json_decode($barang->foto_lain, true) : [];

        if ($request->hasFile('foto_lain')) {
            $index = count($fotoLainPaths) + 1;
            foreach ($request->file('foto_lain') as $foto) {
                $fotoName = "{$barang->id}_{$index}.jpg";
                $foto->move($folder, $fotoName);
                $fotoLainPaths[] = $fotoName;
                $index++;
            }
        }

        $barang->update([
            'kategori_id' => $request->kategori_id,
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'garansi_berlaku_hingga' => $garansi,
            'penitip_id' => $request->penitip_id,
            'foto_lain' => json_encode($fotoLainPaths),
        ]);

        return redirect()->route('gudang.barang.show', $barang->id)->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);

        $folder = public_path("images/barang/{$barang->id}");
        if (File::exists($folder)) {
            File::deleteDirectory($folder);
        }

        $notaPath = storage_path("app/public/notas/nota-barang-{$barang->id}.pdf");
        if (File::exists($notaPath)) {
            File::delete($notaPath);
        }

        $barang->delete();

        return redirect()->route('gudang.barang.index')->with('success', 'Barang berhasil dihapus.');
    }
}
