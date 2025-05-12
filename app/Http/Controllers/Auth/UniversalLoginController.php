<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Pembeli;
use App\Models\Penitip;
use App\Models\Organisasi;
use App\Models\Pegawai;

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

        $username = $request->username;
        $password = $request->password;

        // Cek Pembeli
        $pembeli = Pembeli::where('username', $username)->first();
        if ($pembeli && Hash::check($password, $pembeli->password)) {
            Auth::guard('pembeli')->login($pembeli);
            return redirect('/')->with('success', 'Berhasil login sebagai pembeli');
        }

        // Cek Penitip
        $penitip = Penitip::where('username', $username)->first();
        if ($penitip && Hash::check($password, $penitip->password)) {
            Auth::guard('penitip')->login($penitip);
            return redirect()->route('penitip.dashboard')->with('success', 'Berhasil login sebagai penitip');
        }

        // Cek Organisasi
        $organisasi = Organisasi::where('username', $username)->first();
        if ($organisasi && Hash::check($password, $organisasi->password)) {
            Auth::guard('organisasi')->login($organisasi);
            return redirect()->route('organisasi.dashboard')->with('success', 'Berhasil login sebagai organisasi');
        }

        // ✅ Cek Pegawai
        $pegawai = Pegawai::where('username', $username)->first();
        if ($pegawai && Hash::check($password, $pegawai->password)) {
            Auth::guard('pegawai')->login($pegawai);
            return redirect()->route('pegawai.dashboard')->with('success', 'Berhasil login sebagai pegawai');
        }

        // ❌ Jika tidak ditemukan di manapun
        return back()->withErrors(['username' => 'Username atau password salah']);
    }
}
