<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\KomisiLog;

class KomisiController extends Controller
{
    public function index()
    {
        $hunter = Auth::guard('hunter')->user();

        $komisiLogs = KomisiLog::with(['barang', 'penitip'])
                        ->where('hunter_id', $hunter->id)
                        ->latest()
                        ->get();

        return view('hunter.komisi.index', compact('komisiLogs', 'hunter'));
    }
}
