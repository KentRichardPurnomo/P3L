<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class LaporanMasaPenitipanController extends Controller
{
    public function index()
    {
        $expiredBarangs = Barang::with('penitip')
            ->whereDate('batas_waktu_titip', '<', Carbon::today())
            ->get();

        return view('owner.laporanmasaPenitipan', compact('expiredBarangs'));
    }

    public function download()
    {
        $expiredBarangs = Barang::with('penitip')
            ->whereDate('batas_waktu_titip', '<', Carbon::today())
            ->get();

        if ($expiredBarangs->isEmpty()) {
            return back()->with('error', 'Tidak ada barang dengan masa penitipan yang sudah habis.');
        }

        $pdf = Pdf::loadView('owner.laporan.pdfMasaPenitipan', compact('expiredBarangs'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('laporan-barang-masa-penitipan-habis.pdf');
    }
}


