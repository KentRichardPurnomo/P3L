<?php

namespace App\Http\Controllers\Organisasi;

use App\Http\Controllers\Controller;
use App\Models\Organisasi;
use App\Models\RequestDonasi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class OrganisasiController extends Controller
{
    public function index()
    {
        $organisasi = Auth::guard('organisasi')->user();
        $allRequests = RequestDonasi::where('organisasi_id', '!=', $organisasi->id)->get();

        return view('organisasi.dashboard', compact('organisasi', 'allRequests'));
    }
}
