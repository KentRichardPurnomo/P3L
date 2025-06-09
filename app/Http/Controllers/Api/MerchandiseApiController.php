<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Merchandise;
use App\Models\RedeemPoin;

class MerchandiseApiController extends Controller
{
    public function index(Request $request)
    {
        $pembeliId = $request->query('pembeli_id');

        $merchandiseList = Merchandise::with(['redeemPoins' => function ($query) use ($pembeliId) {
            $query->where('pembeli_id', $pembeliId);
        }])->get();

        $data = $merchandiseList->map(function ($m) {
            $redeem = $m->redeemPoins->first();
            return [
                'id' => $m->id,
                'nama' => $m->nama,
                'harga_poin' => $m->harga_poin,
                'stok' => $m->stok,
                'thumbnail' => $m->thumbnail,
                'status' => $redeem ? $redeem->status : 'belum diklaim',
                'tanggal_ambil' => $redeem?->tanggal_ambil,
            ];
        });

        return response()->json($data);
    }
}
