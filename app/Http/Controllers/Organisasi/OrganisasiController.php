<?php

namespace App\Http\Controllers\Organisasi;

use App\Http\Controllers\Controller;
use App\Models\Organisasi;
use App\Models\RequestDonasi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class OrganisasiController extends Controller
{
    public function index(Request $request)
{
    $organisasi = Auth::guard('organisasi')->user();
    $search = $request->input('cari_request');

    // Ambil semua request donasi dari organisasi lain (filtered jika ada pencarian)
    $allRequests = RequestDonasi::with('organisasi')
        ->where('organisasi_id', '!=', $organisasi->id)
        ->when($search, function ($query) use ($search) {
            $query->where('jenis_barang', 'like', '%' . $search . '%')
                  ->orWhere('alasan', 'like', '%' . $search . '%');
        })
        ->get();

    // Request donasi milik organisasi saat ini (filtered juga)
    $ownRequests = RequestDonasi::where('organisasi_id', $organisasi->id)
        ->when($search, function ($query) use ($search) {
            $query->where('jenis_barang', 'like', '%' . $search . '%')
                  ->orWhere('alasan', 'like', '%' . $search . '%');
        })
        ->get();

    return view('organisasi.dashboard', compact('organisasi', 'ownRequests', 'allRequests'));
}


    public function updateProfilePicture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|max:2048'
        ]);

        $organisasi = Auth::guard('organisasi')->user();

        $file = $request->file('profile_picture');
        $filename = 'org_' . $organisasi->id . '.' . $file->getClientOriginalExtension();

        // Simpan file ke storage
        $path = $file->storeAs('public/profile_pictures', $filename);

        // Simpan nama file ke database
        $organisasi->profile_picture = 'profile_pictures/' . $filename;
        $organisasi->save();

        return back()->with('success', 'Foto profil berhasil diperbarui.');
    }

    public function edit()
    {
        $organisasi = Auth::guard('organisasi')->user();
        return view('organisasi.edit_profil', compact('organisasi'));
    }

    public function update(Request $request)
{
    $request->validate([
        'username' => 'required',
        'email' => 'required|email',
        'no_telp' => 'required',
        'alamat' => 'required',
        'profile_picture' => 'nullable|image|max:2048'
    ]);

    $organisasi = Auth::guard('organisasi')->user();

    $organisasi->username = $request->username;
    $organisasi->email = $request->email;
    $organisasi->no_telp = $request->no_telp;
    $organisasi->alamat = $request->alamat;

    if ($request->hasFile('profile_picture')) {
        $file = $request->file('profile_picture');
        $filename = 'org_' . $organisasi->id . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/profile_pictures', $filename);
        $organisasi->profile_picture = 'profile_pictures/' . $filename;
    }

    $organisasi->save();

    return redirect()->route('organisasi.dashboard')->with('success', 'Profil berhasil diperbarui.');
}


}
