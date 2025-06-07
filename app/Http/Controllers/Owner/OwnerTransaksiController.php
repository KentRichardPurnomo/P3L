<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KomisiLog;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;

class OwnerTransaksiController extends Controller
{
    public function index()
{
    // Ambil semua transaksi_id yang pernah muncul di komisi_logs
    $transaksiList = \App\Models\KomisiLog::pluck('transaksi_id')->unique();

    // Ambil daftar transaksi (distinct) dengan pagination manual
    $transaksiPaginated = $transaksiList->values()->chunk(10); // ambil 10 per halaman (simulasi pagination manual)

    $currentPage = request('page', 1);
    $currentChunk = $transaksiPaginated->get($currentPage - 1, collect());

    return view('owner.transaksi_index', [
        'transaksiList' => $currentChunk,
        'currentPage' => $currentPage,
        'lastPage' => $transaksiPaginated->count(),
    ]);
}

    public function show($id)
    {
        $logs = KomisiLog::with(['barang', 'penitip'])->where('transaksi_id', $id)->get();

        return view('owner.transaksi_detail', compact('logs', 'id'));
    }
}
