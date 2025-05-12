<?php

namespace App\Http\Controllers\Penitip;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Barang;

class DashboardPenitipController extends Controller
{
    public function index()
    {
        // $penitip = Auth::guard('penitip')->user();
        // $barangs = Barang::where('penitip_id', $penitip->id)->get();

        // return view('penitip.dashboard', compact('penitip', 'barangs'));
        $penitip = Auth::guard('penitip')->user();

        $barangAktif = \App\Models\Barang::where('penitip_id', $penitip->id)
                        ->where('terjual', false)
                        ->get();

        $barangTerjual = \App\Models\Barang::where('penitip_id', $penitip->id)
                        ->where('terjual', true)
                        ->get();

        return view('penitip.dashboard', compact('penitip', 'barangAktif', 'barangTerjual'));
    }
}
