<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use Illuminate\Support\Facades\Auth;

class KategoriController extends Controller
{
    public function show($id)
    {
        $kategori = Kategori::with('barangs')->findOrFail($id);
        return view('kategori.show', compact('kategori'));
    }
}
