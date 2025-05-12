<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembeli;
use App\Models\Penitip;
use App\Models\Organisasi;

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

        $user = Pembeli::where('email', $email)->first()
            ?? Penitip::where('email', $email)->first()
            ?? Organisasi::where('email', $email)->first();

        if ($user) {
            // Simulasi: tidak mengirim email asli
            return redirect()->route('password.reset.form', ['email' => $email])
            ->with('success', 'Link reset password telah dikirim ke email Anda (simulasi).');
        }

        return back()->withErrors(['email' => 'Email tidak ditemukan di sistem kami.']);
    }
}
