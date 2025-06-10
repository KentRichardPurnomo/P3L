<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use Carbon\Carbon;
use PDF;

class LaporanPenjualanController extends Controller
{
    public function index(Request $request)
    {
        $tahun = $request->input('tahun', now()->year);

        $dataPerBulan = collect(range(1, 12))->map(function ($bulan) use ($tahun) {
            $transaksiBulan = Transaksi::where('status', 'selesai')
                ->whereYear('tanggal', $tahun)
                ->whereMonth('tanggal', $bulan)
                ->with('detail')
                ->get();

            $jumlahBarang = $transaksiBulan->flatMap->detail->sum('jumlah');
            $totalPendapatan = $transaksiBulan->flatMap->detail->sum('subtotal');

            return [
                'bulan' => Carbon::create()->month($bulan)->translatedFormat('F'),
                'jumlah_barang' => $jumlahBarang,
                'pendapatan' => $totalPendapatan,
                'jumlah_transaksi' => $transaksiBulan->count(),
            ];
        });

        return view('owner.laporan_bulanan.index', compact('dataPerBulan', 'tahun'));
    }

    public function cetakPdf(Request $request)
    {
        $tahun = $request->input('tahun', now()->year);
        $chartImage = $request->input('chart'); // base64

        $dataPerBulan = collect(range(1, 12))->map(function ($bulan) use ($tahun) {
            $transaksiBulan = Transaksi::where('status', 'selesai')
                ->whereYear('tanggal', $tahun)
                ->whereMonth('tanggal', $bulan)
                ->with('detail')
                ->get();

            $jumlahBarang = $transaksiBulan->flatMap->detail->sum('jumlah');
            $totalPendapatan = $transaksiBulan->flatMap->detail->sum('subtotal');

            return [
                'bulan' => Carbon::create()->month($bulan)->translatedFormat('F'),
                'jumlah_barang' => $jumlahBarang,
                'pendapatan' => $totalPendapatan,
                'jumlah_transaksi' => $transaksiBulan->count(),
            ];
        });

        $pdf = PDF::loadView('owner.laporan_bulanan.pdf', [
            'dataPerBulan' => $dataPerBulan,
            'tahun' => $tahun,
            'chartImage' => $chartImage,
        ])->setPaper('A4', 'portrait');
        \Log::info('Chart Base64 Length:', ['length' => strlen($chartImage)]);

        return $pdf->download("Laporan_Penjualan_Bulanan_{$tahun}.pdf");
    }
    
}
