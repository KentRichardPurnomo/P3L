<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfilHunterController extends Controller
{
    public function edit()
    {
        $hunter = Auth::guard('hunter')->user();
        return view('hunter.edit', compact('hunter'));
    }

    public function update(Request $request)
    {
        $hunter = Auth::guard('hunter')->user();

        $request->validate([
            'username' => 'required|string',
            'no_telp' => 'required|string',
            'foto' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('hunter_foto', 'public');
            $hunter->profile_picture = $path;
        }

        $hunter->username = $request->username;
        $hunter->no_telp = $request->no_telp;
        $hunter->save();

        return redirect()->route('hunter.dashboard')->with('success', 'Profil berhasil diperbarui.');
    }
}
