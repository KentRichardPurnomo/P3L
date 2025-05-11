<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\Barang;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $barangs = Barang::latest()->take(10)->get();

        $keyword = $request->query('search');
        
        // $barangs = Barang::query()
        //     ->when($keyword, function ($query, $keyword) {
        //         $query->where('nama', 'like', '%' . $keyword . '%');
        //     })
        //     ->latest()
        //     ->get();

        $kategoris = Kategori::all();

        return view('home', compact('barangs', 'kategoris', 'keyword'));
    }
}
