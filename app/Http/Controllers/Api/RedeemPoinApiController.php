<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RedeemPoin;
use App\Models\Pembeli;
use App\Models\Merchandise;

class RedeemPoinApiController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pembeli_id' => 'required|exists:pembelis,id',
            'merchandise_id' => 'required|exists:merchandises,id',
        ]);

        $pembeli = \App\Models\Pembeli::find($validated['pembeli_id']);
        $merchandise = \App\Models\Merchandise::find($validated['merchandise_id']);

        // ✅ Cek stok dulu
        if ($merchandise->stok <= 0) {
            return response()->json([
                'message' => 'Stok merchandise sudah habis.'
            ], 400);
        }

        // ✅ Cek poin cukup
        if ($pembeli->poin < $merchandise->harga_poin) {
            return response()->json([
                'message' => 'Poin kamu tidak cukup untuk klaim merchandise ini.'
            ], 400);
        }

        // ✅ Kurangi poin dan stok
        $pembeli->poin -= $merchandise->harga_poin;
        $pembeli->save();

        $merchandise->stok -= 1;
        $merchandise->save();

        // ✅ Simpan ke tabel redeem_poin
        $redeem = \App\Models\RedeemPoin::create([
            'pembeli_id' => $pembeli->id,
            'merchandise_id' => $merchandise->id,
            'status' => 'belum diambil',
            'tanggal_ambil' => null,
        ]);

        return response()->json([
            'message' => 'Klaim berhasil!',
            'data' => $redeem,
        ]);
    }


    public function index($pembeli_id)
    {
        $riwayat = \App\Models\RedeemPoin::with('merchandise')
            ->where('pembeli_id', $pembeli_id)
            ->latest()
            ->get()
            ->map(function ($item) {
                return [
                    'nama_merchandise' => $item->merchandise->nama,
                    'thumbnail' => $item->merchandise->thumbnail,
                    'status' => $item->status,
                    'tanggal_ambil' => $item->tanggal_ambil,
                ];
            });

        return response()->json($riwayat);
    }
}
