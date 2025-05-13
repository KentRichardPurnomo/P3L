<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RequestDonasi;
use App\Models\DonasiBarang;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $owner = Auth::guard('owner')->user();
        return view('owner.dashboard', compact('owner'));
    }

    public function requestDonasi()
    {
        $requestDonasi = RequestDonasi::with('organisasi')->latest()->get();
        return view('owner.request', compact('requestDonasi'));
    }

    public function historiDonasi()
    {
        $historiDonasi = DonasiBarang::with('organisasi')->latest()->get();
        return view('owner.histori', compact('historiDonasi'));
    }
}
