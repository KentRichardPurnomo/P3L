<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use Carbon\Carbon;
use PDF;

class LaporanStokGudangController extends Controller
{
    public function index(Request $request)
    {
        $tanggal = $request->input('tanggal');
        $query = Barang::with(['penitip', 'hunter'])
            ->whereIn('status', ['tersedia', 'barang untuk donasi']);

        if ($tanggal) {
            $query->whereDate('created_at', $tanggal);
        }

        $barangs = $query->get();

        return view('owner.laporan_stok.index', compact('barangs', 'tanggal'));
    }

    public function download(Request $request)
    {
        $tanggal = $request->input('tanggal');
        $query = Barang::with(['penitip', 'hunter'])
            ->whereIn('status', ['tersedia', 'barang untuk donasi']);

        if ($tanggal) {
            $query->whereDate('created_at', $tanggal);
        }

        $barangs = $query->get();
        $tanggalCetak = now()->format('d-m-Y');

        $pdf = PDF::loadView('owner.laporan_stok.pdf', compact('barangs', 'tanggal', 'tanggalCetak'))
            ->setPaper('A4', 'landscape');

        return $pdf->download('Laporan_Stok_Gudang_' . ($tanggal ?? 'semua') . '.pdf');
    }
}
