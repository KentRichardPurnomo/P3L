<?php

namespace App\Http\Controllers\CS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RedeemPoin;
use Carbon\Carbon;

class MerchandiseController extends Controller
{
    public function index(Request $request)
    {
        $statusFilter = $request->query('status');

        $query = RedeemPoin::with(['pembeli', 'merchandise']);

        if (in_array($statusFilter, ['belum diambil', 'sudah diambil'])) {
            $query->where('status', $statusFilter);
        }

        $riwayat = $query->latest()->get();

        return view('cs.merchandise_index', compact('riwayat', 'statusFilter'));
    }

    public function updateStatus(Request $request, $id)
    {
        $redeem = RedeemPoin::findOrFail($id);

        $redeem->status = 'sudah diambil';
        $redeem->tanggal_ambil = Carbon::now();
        $redeem->save();

        return redirect()->back()->with('success', 'Status berhasil diperbarui.');
    }
}
