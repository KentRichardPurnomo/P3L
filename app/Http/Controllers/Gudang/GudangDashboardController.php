<?php

namespace App\Http\Controllers\Gudang;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class GudangDashboardController extends Controller
{
    public function index()
    {
        $gudang = Auth::guard('pegawai')->user();
        return view('gudang.dashboard', compact('gudang'));
    }
}
