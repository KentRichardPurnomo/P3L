<?php

namespace App\Http\Controllers\CS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CSDashboardController extends Controller
{
    public function index()
    {
        $cs = Auth::guard('pegawai')->user();
        return view('cs.csdashboard', compact('cs'));
    }
}
