<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RequestDonasi;
use App\Models\Organisasi;


class OwnerController extends Controller
{
    public function index()
    {
        $owner = Auth::guard('owner')->user();
        $requestDonasi = RequestDonasi::with('organisasi')->get(); // HANYA 'organisasi'
        return view('owner.dashboard', compact('owner', 'requestDonasi'));
    }

    public function historyDonasiOrganisasi($organisasi_id)
    {
        // Mengambil semua request donasi yang dikirim ke organisasi tertentu
        $history = RequestDonasi::where('organisasi_id', $organisasi_id)
                                ->with('organisasi')
                                ->get();

        // Ambil data organisasi berdasarkan ID
        $organisasi = Organisasi::findOrFail($organisasi_id);

        return view('owner.history_donasi', compact('organisasi', 'history'));
    }
}
