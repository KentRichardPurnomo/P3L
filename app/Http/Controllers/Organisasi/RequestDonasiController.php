<?php

namespace App\Http\Controllers\Organisasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RequestDonasi;
use Illuminate\Support\Facades\Auth;

class RequestDonasiController extends Controller
{
    public function create()
    {
        return view('organisasi.request_create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_barang' => 'required|string|max:255',
            'alasan' => 'required|string',
        ]);

        RequestDonasi::create([
            'organisasi_id' => Auth::guard('organisasi')->id(),
            'jenis_barang' => $request->jenis_barang,
            'alasan' => $request->alasan,
        ]);

        return redirect()->route('organisasi.dashboard')->with('success', 'Request donasi berhasil dikirim.');
    }
}
