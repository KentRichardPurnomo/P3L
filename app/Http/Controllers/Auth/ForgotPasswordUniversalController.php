<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembeli;
use App\Models\Penitip;
use App\Models\Organisasi;
use App\Models\Pegawai;
use App\Models\Owner;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordUniversalController extends Controller
{
    public function showForm()
    {
        return view('auth.forgotPassword');
    }

    public function sendResetLink(Request $request)
    {
            $request->validate([
            'email' => 'required|email'
        ]);

        $email = $request->email;

        // Cek urutan entitas
        $user = Pembeli::where('email', $email)->first()
            ?? Penitip::where('email', $email)->first()
            ?? Organisasi::where('email', $email)->first();

        // ✅ Khusus Pegawai
        $pegawai = Pegawai::where('email', $email)->first();
        if ($pegawai) {
            // Reset password jadi tanggal lahir
            $tanggal_lahir = $pegawai->tanggal_lahir; // format: YYYY-MM-DD
            $pegawai->password = Hash::make($tanggal_lahir);
            $pegawai->save();

            return redirect()->route('login.universal')->with('success', 'Password pegawai berhasil direset. Silakan login kembali menggunakan tanggal lahir Anda. Format = DD-MM-YYYY');
        }

         // ✅ Owner
        $owner = Owner::where('email', $email)->first();
        if ($owner) {
            $tanggal_lahir = $owner->tanggal_lahir;
            $owner->password = Hash::make($tanggal_lahir);
            $owner->save();

            return redirect()->route('login.universal')->with('success', 'Password berhasil direset. Silakan login kembali menggunakan tanggal lahir Anda. Format = DD-MM-YYYY');
        }

        if ($user) {
            // Simulasi reset (misalnya ke form reset manual)
            return redirect()->route('password.reset.form', ['email' => $email])
                ->with('success', 'Link reset password telah dikirim ke email Anda (simulasi).');
        }

        return back()->withErrors(['email' => 'Email tidak ditemukan di sistem kami.']);
    }
}
