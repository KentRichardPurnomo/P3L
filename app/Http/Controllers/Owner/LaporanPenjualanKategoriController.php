<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanPenjualanKategoriController extends Controller
{
    public function index()
    {
        $data = Barang::where('status', 'Sold Out')
                    ->with('kategori', 'penitip')
                    ->get()
                    ->groupBy(function ($barang) {
                        return $barang->kategori->nama ?? 'Tanpa Kategori';
                    });

        return view('owner.laporanPenjualanKategori', compact('data'));
    }
    public function downloadPerKategori($kategori)
    {
        $kategoriDecoded = urldecode($kategori);

        $barangs = Barang::with('penitip', 'kategori')
            ->whereHas('kategori', function ($query) use ($kategoriDecoded) {
                $query->where('nama', $kategoriDecoded);
            })
            ->where('status', 'sold out') 
            ->get();

        if ($barangs->isEmpty()) {
            return back()->with('error', 'Tidak ada data untuk kategori ini.');
        }

        $pdf = Pdf::loadView('owner.laporan.penjualanKategori', [
            'kategori' => $kategoriDecoded,
            'barangs' => $barangs,
        ])->setPaper('a4', 'portrait');

        return $pdf->download('Laporan_' . str_replace(' ', '_', $kategoriDecoded) . '.pdf');
    }
    public function cetakPDF()
    {
        $data = Barang::where('status', 'Sold Out')
                    ->with('kategori', 'penitip')
                    ->get()
                    ->groupBy(function ($barang) {
                        return $barang->kategori->nama ?? 'Tanpa Kategori';
                    });

        $pdf = Pdf::loadView('owner.laporan.penjualanKategori', compact('data'))
                ->setPaper('a4', 'portrait');

        return $pdf->download('laporan-penjualan-per-kategori.pdf');
    }
}

