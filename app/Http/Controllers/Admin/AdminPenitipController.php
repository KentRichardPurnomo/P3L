<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penitip;
use App\Models\TopSeller;
use App\Models\Barang;
use Carbon\Carbon;

class AdminPenitipController extends Controller
{
    public function index()
    {
        $penitips = Penitip::all();
        $lastMonth = Carbon::now()->subMonth();
        $bulan = $lastMonth->month;
        $tahun = $lastMonth->year;

        $topSellerId = TopSeller::where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->value('penitip_id');

        // Hitung jumlah terjual bulan lalu untuk setiap penitip
        foreach ($penitips as $penitip) {
            $jumlah = Barang::where('penitip_id', $penitip->id)
                ->where('terjual', 1)
                ->whereMonth('updated_at', $bulan)
                ->whereYear('updated_at', $tahun)
                ->count();

            $penitip->jumlah_terjual = $jumlah;
        }

        // Ambil nilai maksimal
        $maxTerjual = $penitips->max(fn($p) => $p->jumlah_terjual);

        // Tandai siapa yang boleh dipilih
        foreach ($penitips as $penitip) {
            $penitip->boleh_dipilih = $penitip->jumlah_terjual > 0 && $penitip->jumlah_terjual === $maxTerjual;
        }

        return view('admin.penitip.penitipListAdmin', compact('penitips', 'topSellerId'));
    }
}
