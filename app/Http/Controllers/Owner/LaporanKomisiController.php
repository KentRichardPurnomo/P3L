<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KomisiLog;
use Carbon\Carbon;
use PDF;

class LaporanKomisiController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->input('bulan', now()->month);
        $tahun = $request->input('tahun', now()->year);

        $data = KomisiLog::with(['barang'])
            ->whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->get()
            ->map(function ($item) {
                $kodeProduk = strtoupper(substr($item->barang->nama, 0, 1)) . $item->barang->id;

                return [
                    'kode_produk' => $kodeProduk,
                    'nama_barang' => $item->barang->nama,
                    'harga_jual' => $item->total_harga,
                    'tanggal_masuk' => $item->barang->created_at->format('d-m-Y'),
                    'tanggal_laku' => $item->created_at->format('d-m-Y'),
                    'komisi_hunter' => $item->komisi_hunter,
                    'komisi_owner' => $item->komisi_owner,
                    'bonus_penitip' => $item->bonus_penitip,
                ];
            });

        return view('owner.laporan_komisi.index', compact('data', 'bulan', 'tahun'));
    }

    public function download(Request $request)
    {
        $bulan = $request->input('bulan', now()->month);
        $tahun = $request->input('tahun', now()->year);
        $tanggalCetak = now()->format('d F Y');

        $data = KomisiLog::with(['barang'])
            ->whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->get()
            ->map(function ($item) {
                $kodeProduk = strtoupper(substr($item->barang->nama, 0, 1)) . $item->barang->id;

                return [
                    'kode_produk' => $kodeProduk,
                    'nama_barang' => $item->barang->nama,
                    'harga_jual' => $item->total_harga,
                    'tanggal_masuk' => $item->barang->created_at->format('d-m-Y'),
                    'tanggal_laku' => $item->created_at->format('d-m-Y'),
                    'komisi_hunter' => $item->komisi_hunter,
                    'komisi_owner' => $item->komisi_owner,
                    'bonus_penitip' => $item->bonus_penitip,
                ];
            });

        $namaBulan = Carbon::create()->month($bulan)->translatedFormat('F');
        $pdf = PDF::loadView('owner.laporan_komisi.pdf', compact('data', 'bulan', 'tahun', 'tanggalCetak', 'namaBulan'))
            ->setPaper('A4', 'landscape');

        return $pdf->download("Laporan_Komisi_{$namaBulan}_{$tahun}.pdf");
    }
}
