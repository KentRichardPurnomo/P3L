<?php

namespace App\Http\Controllers\CS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Barang;

class CSProsesBarangController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::with(['pembeli', 'detail.barang'])
            ->where('status', 'diproses')
            ->get();

        return view('cs.barang-diproses', compact('transaksis'));
    }

    public function show($id)
    {
        $transaksi = Transaksi::with(['pembeli', 'detail.barang'])->findOrFail($id);
        return view('cs.barang-diproses-detail', compact('transaksi'));
    }

    public function selesaikan($id)
    {
        $transaksi = Transaksi::with('detail.barang')->findOrFail($id);

        // Update status transaksi
        $transaksi->status = 'selesai';
        $transaksi->save();

        // Tandai semua barang sebagai terjual
        foreach ($transaksi->detail as $detail) {
            $barang = $detail->barang;
            if ($barang) {
                $barang->terjual = 1;
                $barang->status = 'sold out';
                $barang->save();
            }
        }

        return redirect()->route('cs.barang.diproses')->with('success', 'Transaksi telah diselesaikan.');
    }
}
