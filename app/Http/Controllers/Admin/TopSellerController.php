<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TopSeller;
use App\Models\BonusTopSellerLog;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TopSellerController extends Controller
{
    public function berikanBonus()
    {
        $bulanLalu = now()->subMonth()->month;
        $tahunLalu = now()->subMonth()->year;

        // Cek apakah sudah ada Top Seller bulan lalu
        $topSeller = TopSeller::where('bulan', $bulanLalu)
            ->where('tahun', $tahunLalu)
            ->first();

        if (!$topSeller) {
            return back()->with('error', 'Belum ada Top Seller yang dipilih untuk bulan lalu.');
        }

        // Cek apakah sudah pernah diberikan bonus
        $sudahDiberikan = BonusTopSellerLog::where('penitip_id', $topSeller->penitip_id)
            ->where('bulan', $bulanLalu)
            ->where('tahun', $tahunLalu)
            ->exists();

        if ($sudahDiberikan) {
            return back()->with('info', 'Bonus untuk Top Seller bulan lalu sudah diberikan.');
        }

        // Hitung total penjualan barang milik penitip dari transaksi selesai bulan lalu
        $totalPenjualan = Transaksi::where('status', 'selesai')
            ->whereMonth('tanggal', $bulanLalu)
            ->whereYear('tanggal', $tahunLalu)
            ->with('detailTransaksis.barang')
            ->get()
            ->flatMap(function ($transaksi) {
                return $transaksi->detailTransaksis;
            })
            ->filter(function ($detail) use ($topSeller) {
                return $detail->barang && $detail->barang->penitip_id == $topSeller->penitip_id;
            })
            ->sum('subtotal');

        // Hitung bonus 1%
        $bonus = round($totalPenjualan * 0.01, 2);

        // Tambahkan ke saldo penitip
        DB::table('penitips')->where('id', $topSeller->penitip_id)->increment('saldo', $bonus);

        // Simpan log bonus
        BonusTopSellerLog::create([
            'penitip_id' => $topSeller->penitip_id,
            'bulan' => $bulanLalu,
            'tahun' => $tahunLalu,
            'jumlah_bonus' => $bonus,
            'dibuat_oleh' => Auth::guard('pegawai')->id(), // asumsi admin login pakai guard pegawai
        ]);

        return back()->with('success', 'Bonus Top Seller sebesar Rp' . number_format($bonus, 0, ',', '.') . ' berhasil diberikan.');
    }
}
