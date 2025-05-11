<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Pembeli;
use App\Models\Penitip;

class UniversalLoginController extends Controller
{
    public function form()
    {
        return view('auth.loginUniversal');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required',
        ]);

        // Cek ke pembeli berdasarkan username
        $pembeli = \App\Models\Pembeli::where('username', $request->username)->first();
        if ($pembeli && Hash::check($request->password, $pembeli->password)) {
            Auth::guard('pembeli')->login($pembeli);
            return redirect('/')->with('success', 'Berhasil login sebagai pembeli');
        }

        // Cek ke penitip berdasarkan username
        $penitip = \App\Models\Penitip::where('username', $request->username)->first();
        if ($penitip && Hash::check($request->password, $penitip->password)) {
            Auth::guard('penitip')->login($penitip);
            return redirect()->route('penitip.dashboard')->with('success', 'Berhasil login sebagai penitip');
        }

        // Cek Organisasi
        $organisasi = \App\Models\Organisasi::where('username', $request->username)->first();
        if ($organisasi && Hash::check($request->password, $organisasi->password)) {
            Auth::guard('organisasi')->login($organisasi);
            return redirect()->route('organisasi.dashboard')->with('success', 'Berhasil login sebagai organisasi');
        }

        return back()->withErrors(['username' => 'Username atau password salah']);
    }
}
