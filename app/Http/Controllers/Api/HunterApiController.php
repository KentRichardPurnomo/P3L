<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KomisiLog;
use App\Models\Hunter;

class HunterApiController extends Controller
{
    public function komisiHistory($hunterId)
    {
        $hunter = Hunter::findOrFail($hunterId);

        $logs = KomisiLog::with(['barang', 'penitip'])
            ->where('hunter_id', $hunterId)
            ->orderByDesc('created_at')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $logs
        ]);
    }
}

