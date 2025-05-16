<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AlamatPembeli;
use App\Models\Pembeli;

class AlamatController extends Controller
{
    public function index()
    {
        $pembeli = Auth::guard('pembeli')->user();
        $alamatList = $pembeli->alamat;
        $defaultAlamatId = $pembeli->default_alamat_id;

        return view('pembeli.kelola_alamat', compact('alamatList', 'defaultAlamatId'));
    }

    public function setDefault($id)
    {
        $pembeli = Auth::guard('pembeli')->user();
        $alamat = AlamatPembeli::where('id', $id)->where('pembeli_id', $pembeli->id)->firstOrFail();

        $pembeli->default_alamat_id = $alamat->id;
        $pembeli->save();

        return redirect()->route('pembeli.alamat.index')->with('success', 'Alamat default berhasil diperbarui.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'alamat' => 'required|string|max:255'
        ]);

        AlamatPembeli::create([
            'pembeli_id' => Auth::guard('pembeli')->id(),
            'alamat' => $request->alamat
        ]);

        return redirect()->route('pembeli.alamat.index')->with('success', 'Alamat berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $alamat = AlamatPembeli::where('id', $id)
                    ->where('pembeli_id', Auth::guard('pembeli')->id())
                    ->firstOrFail();

        return view('pembeli.edit_alamat', compact('alamat'));
    }

    public function update(Request $request, $id)
    {
        $alamat = AlamatPembeli::where('id', $id)
                    ->where('pembeli_id', Auth::guard('pembeli')->id())
                    ->firstOrFail();

        $request->validate([
            'alamat' => 'required|string|max:255'
        ]);

        $alamat->alamat = $request->alamat;
        $alamat->save();

        return redirect()->route('pembeli.alamat.index')->with('success', 'Alamat berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $alamat = AlamatPembeli::where('id', $id)
                    ->where('pembeli_id', Auth::guard('pembeli')->id())
                    ->firstOrFail();

        // jika alamat yang dihapus adalah default, kosongkan default
        $pembeli = Auth::guard('pembeli')->user();
        if ($pembeli->default_alamat_id == $alamat->id) {
            $pembeli->default_alamat_id = null;
            $pembeli->save();
        }

        $alamat->delete();

        return redirect()->route('pembeli.alamat.index')->with('success', 'Alamat berhasil dihapus.');
    }

}
