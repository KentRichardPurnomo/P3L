<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginApiController;
use App\Models\Barang;
use App\Models\Kategori;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//halaman Umum 5 barang terbaru
Route::get('/barang-terbaru', function () {
    return Barang::where('terjual', 0)
        ->latest()
        ->take(5)
        ->get()
        ->map(function ($b) {
            return [
                'id' => $b->id,
                'nama' => $b->nama,
                'harga' => $b->harga,
                'thumbnail' => url("images/barang/{$b->id}/{$b->id}.jpg"),
            ];
        });
});

//kategori
Route::get('/kategori', function () {
    return Kategori::select('id', 'nama')->get();
});

//page list barang
Route::get('/barang', function (Request $request) {
    $perPage = $request->per_page ?? 10;

    return Barang::where('terjual', 0)
        ->latest()
        ->paginate($perPage)
        ->through(function ($b) {
            return [
                'id' => $b->id,
                'nama' => $b->nama,
                'harga' => $b->harga,
                'thumbnail' => url("images/barang/{$b->id}/{$b->id}.jpg"),
            ];
        });
});

//detail barang
Route::get('/barang/{id}', function ($id) {
    $barang = \App\Models\Barang::with(['kategori', 'penitip'])->findOrFail($id);

    $fotoLain = json_decode($barang->foto_lain ?? '[]');

    return response()->json([
        'id' => $barang->id,
        'nama' => $barang->nama,
        'harga' => $barang->harga,
        'kategori' => $barang->kategori->nama,
        'kategori_id' => $barang->kategori_id,
        'deskripsi' => $barang->deskripsi,
        'garansi' => $barang->garansi_berlaku_hingga,
        'terjual' => $barang->terjual,
        'penitip' => [
            'username' => $barang->penitip->username,
            'rating' => round($barang->penitip->averageRating(), 1),
        ],
        'thumbnail' => url("images/barang/{$barang->id}/{$barang->id}.jpg"),
        'foto_lain' => collect($fotoLain)->map(fn($f) => url("images/barang/{$barang->id}/$f")),
    ]);
});

//rekomend barang lainnya di detail barang
Route::get('/barang-rekomendasi/{kategori_id}/{exclude_id}', function ($kategori_id, $exclude_id) {
    return \App\Models\Barang::where('kategori_id', $kategori_id)
        ->where('id', '!=', $exclude_id)
        ->where('terjual', 0)
        ->latest()
        ->take(6)
        ->get()
        ->map(fn($b) => [
            'id' => $b->id,
            'nama' => $b->nama,
            'harga' => $b->harga,
            'thumbnail' => url("images/barang/{$b->id}/{$b->id}.jpg")
        ]);
});


Route::post('/login', [LoginApiController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
