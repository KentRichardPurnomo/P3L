<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Barang;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    public function showDetail($transaksiId, $barangId)
    {
        $transaksi = Transaksi::with(['detail.barang', 'pembeli'])->findOrFail($transaksiId);

        // Cek apakah transaksi milik pembeli yang login
        if ($transaksi->pembeli_id !== Auth::guard('pembeli')->id()) {
            abort(403);
        }

        $detail = $transaksi->detail->firstWhere('barang_id', $barangId);

        if (!$detail) {
            abort(404, 'Barang tidak ditemukan dalam transaksi ini.');
        }

        $barang = $detail->barang;
        $jumlah = $detail->jumlah;
        $subtotal = $detail->subtotal;

        $tanggalKirim = $transaksi->tanggal;
        $tanggalSampai = \Carbon\Carbon::parse($tanggalKirim)->addDays(3);
        $alamatTujuan = $transaksi->alamat_pengiriman ?? $transaksi->pembeli->alamat_pembeli->id ?? 'Alamat tidak tersedia';

        return view('pembeli.detail_transaksi', compact(
            'barang', 'jumlah', 'subtotal', 'tanggalKirim', 'tanggalSampai', 'alamatTujuan'
        ));
    }
}
