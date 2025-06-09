<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginApiController;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Penitip;
use App\Models\Pembeli;
use App\Models\Transaksi;
use App\Models\Hunter;
use Illuminate\Support\Carbon;
use App\Models\TopSeller;
use App\Http\Controllers\Api\MerchandiseApiController;
use App\Http\Controllers\Api\RedeemPoinApiController;

// Login API
Route::post('/login', [LoginApiController::class, 'login']);

// Produk Terbaru
Route::get('/barang-terbaru', function () {
    return Barang::where('terjual', 0)
        ->latest()
        ->take(5)
        ->get()
        ->map(fn($b) => [
            'id' => $b->id,
            'nama' => $b->nama,
            'harga' => $b->harga,
            'thumbnail' => url("images/barang/{$b->id}/{$b->id}.jpg"),
        ]);
});

// 🔎 Pencarian
Route::get('/barang/search', function (Request $request) {
    $q = $request->query('q');

    return Barang::where('terjual', 0)
        ->where('nama', 'like', "%$q%")
        ->latest()
        ->get()
        ->map(fn($b) => [
            'id' => $b->id,
            'nama' => $b->nama,
            'harga' => $b->harga,
            'thumbnail' => url("images/barang/{$b->id}/{$b->id}.jpg"),
        ]);
});

// Semua Barang (pagination)
Route::get('/barang', function (Request $request) {
    $perPage = $request->per_page ?? 10;

    return Barang::where('terjual', 0)
        ->latest()
        ->paginate($perPage)
        ->through(fn($b) => [
            'id' => $b->id,
            'nama' => $b->nama,
            'harga' => $b->harga,
            'thumbnail' => url("images/barang/{$b->id}/{$b->id}.jpg"),
        ]);
});

//ambil detail barang
Route::get('/barang/{id}', function ($id) {
    $barang = Barang::with(['kategori', 'penitip'])->findOrFail($id);
    $fotoLain = json_decode($barang->foto_lain ?? '[]');

    $lastMonth = Carbon::now()->subMonth();

    return [
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
            'top_seller' => TopSeller::where('penitip_id', $barang->penitip->id)
                ->where('bulan', $lastMonth->month)
                ->where('tahun', $lastMonth->year)
                ->exists(),
        ],
        'thumbnail' => url("images/barang/{$barang->id}/{$barang->id}.jpg"),
        'foto_lain' => collect($fotoLain)->map(fn($f) => url("images/barang/{$barang->id}/$f")),
    ];
});

// Kategori
Route::get('/kategori', fn () => Kategori::select('id', 'nama')->get());

// Barang per Kategori
Route::get('/kategori/{id}/barang', function ($id) {
    return Barang::where('kategori_id', $id)
        ->where('terjual', 0)
        ->latest()
        ->get()
        ->map(fn($b) => [
            'id' => $b->id,
            'nama' => $b->nama,
            'harga' => $b->harga,
            'thumbnail' => url("images/barang/{$b->id}/{$b->id}.jpg"),
        ]);
});

// Rekomendasi barang lain
Route::get('/barang-rekomendasi/{kategori_id}/{exclude_id}', function ($kategori_id, $exclude_id) {
    return Barang::where('kategori_id', $kategori_id)
        ->where('id', '!=', $exclude_id)
        ->where('terjual', 0)
        ->latest()
        ->take(6)
        ->get()
        ->map(fn($b) => [
            'id' => $b->id,
            'nama' => $b->nama,
            'harga' => $b->harga,
            'thumbnail' => url("images/barang/{$b->id}/{$b->id}.jpg"),
        ]);
});

//penitip
Route::get('/penitip/{id}/profil', function ($id) {
    $penitip = \App\Models\Penitip::findOrFail($id);

    $lastMonth = \Carbon\Carbon::now()->subMonth();
    $isTopSeller = \App\Models\TopSeller::where('penitip_id', $penitip->id)
        ->where('bulan', $lastMonth->month)
        ->where('tahun', $lastMonth->year)
        ->exists();

    return [
        'id' => $penitip->id,
        'username' => $penitip->username,
        'email' => $penitip->email,
        'no_telp' => $penitip->no_telp,
        'saldo' => (int) $penitip->saldo,
        'profile_picture' => $penitip->profile_picture
            ? asset('storage/' . $penitip->profile_picture)
            : null,
        'top_seller' => $isTopSeller, // ✅ ini tambahan baru
    ];
});

Route::post('/penitip/update-fcm-token', function (Request $request) {
    $request->validate([
        'id' => 'required|exists:penitips,id',
        'token' => 'required|string'
    ]);

    $penitip = Penitip::find($request->id);
    $penitip->fcm_token = $request->token;
    $penitip->save();

    return response()->json(['message' => 'Token updated'], 200);
});

//barang aktif penitip
Route::get('/penitip/{id}/barang-aktif', function ($id) {
    return \App\Models\Barang::where('penitip_id', $id)
        ->where('terjual', 0)
        ->with('kategori')
        ->orderByDesc('created_at')
        ->get()
        ->map(fn($b) => [
            'id' => $b->id,
            'nama' => $b->nama,
            'harga' => $b->harga,
            'kategori' => $b->kategori->nama,
            'status_perpanjangan' => $b->status_perpanjangan,
            'status_pengambilan' => $b->status_pengambilan,
            'batas_waktu_titip' => $b->batas_waktu_titip,
            'thumbnail' => url("images/barang/{$b->id}/{$b->id}.jpg"),
        ]);
});

//barang terjual penitip
Route::get('/penitip/{id}/barang-terjual', function ($id) {
    return \App\Models\Barang::where('penitip_id', $id)
        ->where('terjual', 1)
        ->orderByDesc('updated_at')
        ->get()
        ->map(fn($b) => [
            'id' => $b->id,
            'nama' => $b->nama,
            'harga' => $b->harga,
            'thumbnail' => url("images/barang/{$b->id}/{$b->id}.jpg"),
        ]);
});

//notif dalam app penitip
Route::get('/penitip/{id}/notifikasi', function ($id) {
    $penitip = \App\Models\Penitip::findOrFail($id);
    return $penitip->unreadNotifications->map(function ($n) {
        return [
            'pesan' => $n->data['pesan'] ?? 'Ada notifikasi baru.',
            'created_at' => $n->created_at->diffForHumans()
        ];
    });
});

// Profil Pembeli
Route::get('/pembeli/{id}/profil', function ($id) {
    $pembeli = Pembeli::with('defaultAlamat')->find($id);

    if (!$pembeli) {
        return response()->json(['message' => 'Pembeli tidak ditemukan'], 404);
    }

    return [
        'id' => $pembeli->id,
        'username' => $pembeli->username,   
        'email' => $pembeli->email,
        'no_telp' => $pembeli->no_telp,
        'profile_picture' => $pembeli->profile_picture
            ? asset('storage/' . $pembeli->profile_picture)
            : null,
        'alamat_utama' => optional($pembeli->defaultAlamat)->alamat,
        'poin' => (int) $pembeli->poin,
    ];
});

// Update FCM Token Pembeli
Route::post('/pembeli/update-fcm-token', function (Request $request) {
    $request->validate([
        'id' => 'required|exists:pembelis,id',
        'token' => 'required|string'
    ]);

    $pembeli = Pembeli::findOrFail($request->id);
    $pembeli->fcm_token = $request->token;
    $pembeli->save();

    return response()->json(['message' => 'Token FCM berhasil diperbarui.'], 200);
});

// Notifikasi Pembeli
Route::get('/pembeli/{id}/notifikasi', function ($id) {
    $pembeli = Pembeli::findOrFail($id);
    return $pembeli->unreadNotifications->map(function ($notif) {
        return [
            'pesan' => $notif->data['pesan'] ?? 'Ada notifikasi baru.',
            'created_at' => $notif->created_at->diffForHumans()
        ];
    });
});

//histori pembeli
Route::get('/pembeli/{id}/riwayat-transaksi', function ($id) {
    $transaksis = Transaksi::where('pembeli_id', $id)
        ->with(['detail.barang'])
        ->orderByDesc('tanggal')
        ->get();

    return $transaksis->map(function ($transaksi) {
        return [
            'id' => $transaksi->id,
            'tanggal' => Carbon::parse($transaksi->tanggal)->format('Y-m-d H:i'),
            'status' => $transaksi->status,
            'total' => $transaksi->total,
            'detail' => $transaksi->detail->map(function ($item) {
                if (!$item->barang) return null;
                return [
                    'nama' => $item->barang->nama,
                    'harga' => $item->barang->harga,
                    'thumbnail' => url("images/barang/{$item->barang->id}/{$item->barang->thumbnail}"),
                ];
            })->filter()->values(),
        ];
    });
});

//histori detail pembeli
Route::get('/pembeli/transaksi/{id}', function ($id) {
    $transaksi = Transaksi::with(['detail.barang', 'alamat'])->findOrFail($id);

    return [
        'id' => $transaksi->id,
        'tanggal' => $transaksi->tanggal,
        'status' => $transaksi->status,
        'tipe_pengiriman' => $transaksi->tipe_pengiriman,
        'alamat' => optional($transaksi->alamat)->alamat,
        'poin_ditukar' => $transaksi->poin_ditukar,
        'potongan' => $transaksi->potongan,
        'total' => $transaksi->total,
        'detail' => $transaksi->detail->map(function ($item) {
            if (!$item->barang) return null;
            return [
                'nama' => $item->barang->nama,
                'harga' => $item->barang->harga,
                'subtotal' => $item->subtotal,
                'thumbnail' => url("images/barang/{$item->barang->id}/{$item->barang->thumbnail}"),
            ];
        })->filter()->values(),
    ];
});

//hunter
Route::get('/hunter/{id}/profil', function ($id) {
    $hunter = \App\Models\Hunter::findOrFail($id);
    return [
        'id' => $hunter->id,
        'username' => $hunter->username,
        'email' => $hunter->email,
        'no_telp' => $hunter->no_telp,
        'saldo' => (int) $hunter->saldo,
        'profile_picture' => $hunter->profile_picture
            ? asset('storage/' . $hunter->profile_picture)
            : null,
    ];
});

Route::post('/hunter/update-fcm-token', function (Request $request) {
    $request->validate([
        'id' => 'required|exists:hunters,id',
        'token' => 'required|string'
    ]);

    $hunter = Hunter::find($request->id);
    $hunter->fcm_token = $request->token;
    $hunter->save();

    return response()->json(['message' => 'Token updated'], 200);
});

//merch
Route::get('/merchandise', [MerchandiseApiController::class, 'index']);

Route::post('/redeem-poin', [RedeemPoinApiController::class, 'store']);
Route::get('/redeem-poin/{pembeli_id}', [RedeemPoinApiController::class, 'index']);