<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Merchandise;
use Illuminate\Support\Facades\Storage;

class AdminMerchandiseController extends Controller
{
    public function index()
    {
        $merchandises = Merchandise::all();
        return view('admin.merchandise.index', compact('merchandises'));
    }

    public function create()
    {
        return view('admin.merchandise.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'harga_poin' => 'required|integer|min:0',
            'stok' => 'required|integer|min:0',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $thumbnailPath = $request->file('thumbnail')->store('merchandise_thumbnails', 'public');

        Merchandise::create([
            'nama' => $request->nama,
            'harga_poin' => $request->harga_poin,
            'stok' => $request->stok,
            'thumbnail' => $thumbnailPath,
        ]);

        return redirect()->route('admin.merchandise.index')->with('success', 'Merchandise berhasil ditambahkan.');
    }

    public function edit(Merchandise $merchandise)
    {
        return view('admin.merchandise.edit', compact('merchandise'));
    }

    public function update(Request $request, Merchandise $merchandise)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'harga_poin' => 'required|integer|min:0',
            'stok' => 'required|integer|min:0',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($merchandise->thumbnail && Storage::disk('public')->exists($merchandise->thumbnail)) {
                Storage::disk('public')->delete($merchandise->thumbnail);
            }
            $merchandise->thumbnail = $request->file('thumbnail')->store('merchandise_thumbnails', 'public');
        }

        $merchandise->update([
            'nama' => $request->nama,
            'harga_poin' => $request->harga_poin,
            'stok' => $request->stok,
            'thumbnail' => $merchandise->thumbnail,
        ]);

        return redirect()->route('admin.merchandise.index')->with('success', 'Merchandise berhasil diperbarui.');
    }

    public function destroy(Merchandise $merchandise)
    {
        if ($merchandise->thumbnail && Storage::disk('public')->exists($merchandise->thumbnail)) {
            Storage::disk('public')->delete($merchandise->thumbnail);
        }
        $merchandise->delete();

        return redirect()->route('admin.merchandise.index')->with('success', 'Merchandise berhasil dihapus.');
    }
}
