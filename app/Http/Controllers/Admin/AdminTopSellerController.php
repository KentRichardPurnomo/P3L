<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Penitip;
use App\Models\TopSeller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AdminTopSellerController extends Controller
{

    public function index()
    {
        $lastMonth = Carbon::now()->subMonth();
        $bulan = $lastMonth->month;
        $tahun = $lastMonth->year;

        // Ambil semua barang sold out bulan lalu
        $barangSold = Barang::where('terjual', 1)
            ->whereMonth('updated_at', $bulan)
            ->whereYear('updated_at', $tahun)
            ->get();

        // Hitung per penitip
        $penitipData = $barangSold->groupBy('penitip_id')->map(function ($items, $penitip_id) {
            return [
                'penitip' => Penitip::find($penitip_id),
                'terjual_bulan_lalu' => $items->count(),
                'total_barang_dititipkan' => Barang::where('penitip_id', $penitip_id)->count(),
            ];
        });

        // Ambil top seller dari database bulan lalu (jika sudah ditetapkan)
        $topSeller = TopSeller::where('bulan', $bulan)->where('tahun', $tahun)->first();

        return view('admin.top_seller.index', [
            'penitipData' => $penitipData,
            'topSeller' => $topSeller,
            'bulan' => $bulan,
            'tahun' => $tahun,
        ]);
    }

    public function setTopSeller(Request $request, $penitip_id)
    {
        $lastMonth = Carbon::now()->subMonth();
        $bulan = $lastMonth->month;
        $tahun = $lastMonth->year;

        // Cegah duplikat
        if (TopSeller::where('bulan', $bulan)->where('tahun', $tahun)->exists()) {
            return back()->with('error', 'Top seller bulan lalu sudah dipilih.');
        }

        TopSeller::create([
            'penitip_id' => $penitip_id,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'dibuat_oleh' => Auth::guard('pegawai')->id(),
        ]);

        return back()->with('success', 'Top seller bulan lalu berhasil ditetapkan.');
    }

    public function batalTopSeller()
    {
        $lastMonth = Carbon::now()->subMonth();

        $topSeller = TopSeller::where('bulan', $lastMonth->month)
            ->where('tahun', $lastMonth->year)
            ->first();

        if ($topSeller) {
            $topSeller->delete();
            return back()->with('success', 'Top seller bulan lalu berhasil dibatalkan.');
        }

        return back()->with('error', 'Belum ada top seller untuk bulan lalu.');
    }
}
