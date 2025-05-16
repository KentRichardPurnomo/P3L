<?php

namespace App\Http\Controllers\Penitip;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Barang;

class DashboardPenitipController extends Controller
{
    public function index()
    {
        $penitip = Auth::guard('penitip')->user();

        $barangAktif = Barang::where('penitip_id', $penitip->id)
                        ->where('terjual', false)
                        ->get();

        $barangTerjual = Barang::where('penitip_id', $penitip->id)
                        ->where('terjual', true)
                        ->get();

        // Barang yang tidak pernah laku = belum pernah masuk ke detailTransaksis
        $barangTidakLaku = Barang::where('penitip_id', $penitip->id)
                            ->whereDoesntHave('detailTransaksis')
                            ->get();

        return view('penitip.dashboard', compact('penitip', 'barangAktif', 'barangTerjual', 'barangTidakLaku'));
    }
}
