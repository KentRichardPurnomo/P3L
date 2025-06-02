<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\DiskusiController;
use App\Http\Controllers\Auth\PembeliAuthController;
use App\Http\Controllers\Pembeli\ProfilController;
use App\Http\Controllers\Auth\PenitipAuthController;
use App\Http\Controllers\Penitip\DashboardPenitipController;
use App\Http\Controllers\Penitip\ProfilPenitipController;
use App\Http\Controllers\Auth\UniversalLoginController;
use App\Http\Controllers\Auth\RegisterAllController;
use App\Http\Controllers\Organisasi\OrganisasiController;
use App\Http\Controllers\Organisasi\RequestDonasiController;
use App\Http\Controllers\Auth\ForgotPasswordUniversalController;
use App\Http\Controllers\Auth\ResetPasswordUniversalController;
use App\Http\Controllers\Auth\LoginUniversalController;
use App\Http\Controllers\Pegawai\PegawaiController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminJabatanController;
use App\Http\Controllers\Admin\AdminOrganisasiController;
use App\Http\Controllers\Pembeli\AlamatController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\CS\CSPenitipController;
use App\Http\Controllers\CS\CSDashboardController;
use App\Http\Controllers\CS\CSBarangController;
use App\Http\Controllers\CS\CSDiskusiController;
use App\Http\Controllers\Pembeli\TransaksiController;
use App\Http\Controllers\Gudang\GudangDashboardController;
use App\Http\Controllers\Gudang\BarangGudangController;
use App\Http\Controllers\HunterDashboardController;
use App\Http\Controllers\AdminHunterController;
use App\Services\FirebaseMessagingService;

Route::get('/login', [LoginUniversalController::class, 'showLoginForm'])->name('login.universal');
Route::post('/login', [LoginUniversalController::class, 'login'])->name('login.universal.submit');

// owner
Route::middleware(['auth:owner'])->prefix('owner')->name('owner.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Owner\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/request-donasi', [\App\Http\Controllers\Owner\DashboardController::class, 'requestDonasi'])->name('request');
    Route::get('/histori-donasi', [\App\Http\Controllers\Owner\DashboardController::class, 'historiDonasi'])->name('histori');

    Route::get('/alokasi/{requestDonasi}', [\App\Http\Controllers\Owner\AlokasiController::class, 'form'])->name('alokasi.form');
    Route::post('/alokasi/{requestDonasi}', [\App\Http\Controllers\Owner\AlokasiController::class, 'store'])->name('alokasi.store');

    Route::get('/donasi/{id}/edit', [\App\Http\Controllers\Owner\DonasiController::class, 'edit'])->name('donasi.edit');
    Route::put('/donasi/{id}', [\App\Http\Controllers\Owner\DonasiController::class, 'update'])->name('donasi.update');
});




// Dashboard pegawai (blank sementara)
Route::get('/pegawai/dashboard', [PegawaiController::class, 'dashboard'])->name('pegawai.dashboard')->middleware('auth:pegawai');
Route::prefix('cs')->middleware('auth:pegawai')->group(function () {
    Route::get('/penitip', [CSPenitipController::class, 'index'])->name('cs.penitip.index');
    Route::get('/penitip/{id}/barang', [CSPenitipController::class, 'barangPenitip'])->name('cs.penitip.barang');
    Route::get('/semua-barang', [CSPenitipController::class, 'semuaBarang'])->name('cs.barang.semua');
});

Route::get('/cs/dashboard', [CSDashboardController::class, 'index'])->name('cs.dashboard');

Route::prefix('cs')->middleware('auth:pegawai')->group(function () {
    Route::get('/penitip', [CSPenitipController::class, 'index'])->name('cs.penitip.index');
    Route::get('/penitip/create', [CSPenitipController::class, 'create'])->name('cs.penitip.create');
    Route::post('/penitip', [CSPenitipController::class, 'store'])->name('cs.penitip.store');
    Route::get('/penitip/{id}/edit', [CSPenitipController::class, 'edit'])->name('cs.penitip.edit');
    Route::put('/penitip/{id}', [CSPenitipController::class, 'update'])->name('cs.penitip.update');
    Route::delete('/penitip/{id}', [CSPenitipController::class, 'destroy'])->name('cs.penitip.destroy');
    Route::get('/konfirmasi-transfer', [\App\Http\Controllers\CS\CSKonfirmasiController::class, 'index'])
        ->name('cs.konfirmasi.index');
    Route::post('/konfirmasi-transfer/{id}', [\App\Http\Controllers\CS\CSKonfirmasiController::class, 'updateStatus'])
        ->name('cs.konfirmasi.update');
    Route::get('/barang-diproses', [\App\Http\Controllers\CS\CSProsesBarangController::class, 'index'])
        ->name('cs.barang.diproses');

    Route::get('/barang-diproses/{id}', [\App\Http\Controllers\CS\CSProsesBarangController::class, 'show'])
        ->name('cs.barang.diproses.detail');

    Route::post('/barang-diproses/{id}/selesaikan', [\App\Http\Controllers\CS\CSProsesBarangController::class, 'selesaikan'])
        ->name('cs.barang.diproses.selesaikan');
});
Route::post('/penitip', [CSPenitipController::class, 'store'])->name('cs.penitip.store');
Route::get('/barang/create', [CSBarangController::class, 'create'])->name('cs.barang.create');
Route::post('/barang', [CSBarangController::class, 'store'])->name('cs.barang.store');
Route::get('/cs/barang/{id}', [CSBarangController::class, 'show'])->name('cs.barang.show');
Route::get('/barang/{id}/edit', [CSBarangController::class, 'edit'])->name('cs.barang.edit');
Route::put('/barang/{id}', [CSBarangController::class, 'update'])->name('cs.barang.update');

Route::post('/cs/diskusi/{id}/balas', [CSDiskusiController::class, 'balas'])->name('cs.diskusi.balas');
Route::get('/cs/diskusi-belum-dibalas', [\App\Http\Controllers\CS\CSBarangController::class, 'diskusiBelumDibalas'])
    ->name('cs.diskusi.belumdibalas');



//admin
Route::prefix('admin')->middleware(['auth:pegawai', 'admin.only'])->group(function () {
    Route::get('/organisasi', [AdminOrganisasiController::class, 'index'])->name('admin.organisasi.index');
    Route::get('/organisasi/{username}/edit', [AdminOrganisasiController::class, 'edit'])->name('admin.organisasi.edit');
    Route::put('/organisasi/{username}', [AdminOrganisasiController::class, 'update'])->name('admin.organisasi.update');
});

Route::middleware(['auth:pegawai'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/pegawai', [\App\Http\Controllers\Admin\PegawaiController::class, 'index'])->name('pegawai.index');
});


Route::delete('/organisasi/{id}', [AdminOrganisasiController::class, 'destroy'])->name('admin.organisasi.destroy');

Route::get('/jabatan', [AdminJabatanController::class, 'index'])->name('admin.jabatan.index');
Route::get('/jabatan/{id}/edit', [AdminJabatanController::class, 'edit'])->name('admin.jabatan.edit');
Route::put('/jabatan/{id}', [AdminJabatanController::class, 'update'])->name('admin.jabatan.update');
Route::delete('/jabatan/{id}', [AdminJabatanController::class, 'destroy'])->name('admin.jabatan.destroy');
Route::get('/jabatan', [AdminJabatanController::class, 'index'])->name('admin.jabatan.index');
Route::get('/jabatan/create', [AdminJabatanController::class, 'create'])->name('admin.jabatan.create');
Route::post('/jabatan', [AdminJabatanController::class, 'store'])->name('admin.jabatan.store');
Route::get('/jabatan/{id}/edit', [AdminJabatanController::class, 'edit'])->name('admin.jabatan.edit');
Route::put('/jabatan/{id}', [AdminJabatanController::class, 'update'])->name('admin.jabatan.update');
Route::delete('/jabatan/{id}', [AdminJabatanController::class, 'destroy'])->name('admin.jabatan.destroy');
Route::delete('/pegawai/{id}', [AdminJabatanController::class, 'destroyPegawai'])->name('admin.pegawai.destroy');

Route::get('/pegawai/{id}/edit', [AdminJabatanController::class, 'editPegawai'])->name('admin.pegawai.edit');
Route::put('/pegawai/{id}', [AdminJabatanController::class, 'updatePegawai'])->name('admin.pegawai.update');



// Tambah pegawai di jabatan tertentu
Route::get('/jabatan/{id}/pegawai/create', [AdminJabatanController::class, 'createPegawai'])->name('admin.jabatan.pegawai.create');
Route::post('/jabatan/{id}/pegawai', [AdminJabatanController::class, 'storePegawai'])->name('admin.jabatan.pegawai.store');

// Tambahan: lihat pegawai berdasarkan jabatan
Route::get('/jabatan/{id}/pegawai', [AdminJabatanController::class, 'pegawai'])->name('admin.jabatan.pegawai');

Route::prefix('admin')->middleware(['auth:pegawai', 'admin.only'])->group(function () {
    Route::get('/jabatan', [JabatanController::class, 'index'])->name('jabatan.index');
    Route::get('/jabatan/{id}/edit', [JabatanController::class, 'edit'])->name('jabatan.edit');
    Route::put('/jabatan/{id}', [JabatanController::class, 'update'])->name('jabatan.update');
    Route::delete('/jabatan/{id}', [JabatanController::class, 'destroy'])->name('jabatan.destroy');
});

Route::prefix('admin')->middleware(['auth:pegawai', 'admin.only'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('/jabatan', JabatanController::class);
});

Route::prefix('admin')->middleware('auth:pegawai')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Jabatan CRUD
    Route::resource('/jabatan', JabatanController::class);
});

Route::middleware(['auth:pegawai'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/hunters/create', [AdminHunterController::class, 'create'])->name('hunter.create');
    Route::post('/hunters', [AdminHunterController::class, 'store'])->name('hunter.store');
});

//Pegawai Gudang
Route::middleware(['auth:pegawai'])->group(function () {
    Route::get('/gudang/dashboard', [GudangDashboardController::class, 'index'])->name('gudang.dashboard');
});
Route::prefix('gudang')->middleware(['auth:pegawai'])->group(function () {
    Route::get('/barang/create', [BarangGudangController::class, 'create'])->name('gudang.barang.create');
    Route::get('/gudang/barang', [BarangGudangController::class, 'index'])->name('gudang.barang.index');
    Route::get('/gudang/barang/transaksi', [BarangGudangController::class, 'transaksi'])->name('gudang.barang.transaksi');
    
    Route::get('/gudang/barang/{id}/ambil', [BarangGudangController::class, 'formPengambilan'])->name('gudang.barang.formAmbil');
    Route::post('/gudang/barang/{id}/catat-pengambilan', [BarangGudangController::class, 'simpanPengambilan'])->name('gudang.barang.simpanPengambilan');

    Route::post('/gudang/barang', [BarangGudangController::class, 'store'])->name('gudang.barang.store');
    Route::get('/gudang/barang/{id}', [BarangGudangController::class, 'show'])->name('gudang.barang.show');
    Route::get('/gudang/barang/{id}/edit', [BarangGudangController::class, 'edit'])->name('gudang.barang.edit');
    Route::delete('/gudang/barang/{id}', [BarangGudangController::class, 'destroy'])->name('gudang.barang.destroy');
    Route::put('/gudang/barang/{id}', [BarangGudangController::class, 'update'])->name('gudang.barang.update');

    Route::get('/gudang/barang/{id}/jadwal-kirim', [BarangGudangController::class, 'formJadwalKirim'])->name('gudang.barang.jadwal');
    Route::post('/gudang/barang/{id}/jadwal-kirim', [BarangGudangController::class, 'simpanJadwalKirim'])->name('gudang.barang.simpanJadwal');
    Route::get('/gudang/barang/{id}/cetak-nota', [BarangGudangController::class, 'cetakNota'])->name('gudang.barang.cetakNota');
    Route::get('/gudang/atur-pengambilan-barang/{id}', [BarangGudangController::class, 'formJadwalAmbil'])->name('gudang.jadwal-ambil.form');
    Route::post('/gudang/atur-pengambilan-barang/{id}', [BarangGudangController::class, 'simpanJadwalAmbil'])->name('gudang.jadwal-ambil.simpan');
    Route::get('/gudang/barang/{id}/nota-pengambilan', [BarangGudangController::class, 'cetakNotaPengambilan'])->name('gudang.barang.notaPengambilan');
    Route::post('/gudang/barang/{id}/konfirmasi-pengambilan', [BarangGudangController::class, 'konfirmasiPengambilan'])->name('gudang.barang.konfirmasi');

});

//hunter (biar gampang)
Route::middleware(['auth:hunter'])->group(function () {
    Route::get('/hunter/dashboard', [HunterDashboardController::class, 'index'])->name('hunter.dashboard');
});


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/masuk', function () {
    return view('auth.choose-role');
})->name('choose.role');

Route::get('/login-universal', [UniversalLoginController::class, 'form'])->name('login.universal.form');
Route::post('/login-universal', [UniversalLoginController::class, 'login'])->name('login.universal');

Route::get('/password/forgot', [ForgotPasswordUniversalController::class, 'showRequestForm'])->name('password.request');
Route::post('/password/forgot', [ForgotPasswordUniversalController::class, 'sendResetLink'])->name('password.email');

Route::get('/lupa-password', [ForgotPasswordUniversalController::class, 'showForm'])->name('password.forgot');
Route::post('/lupa-password', [ForgotPasswordUniversalController::class, 'sendResetLink'])->name('password.send');

Route::get('/reset-password/{email}', [ResetPasswordUniversalController::class, 'showForm'])->name('password.reset.form');
Route::post('/reset-password/{email}', [ResetPasswordUniversalController::class, 'update'])->name('password.reset.update');

Route::get('/register-all', [RegisterAllController::class, 'showForm'])->name('register.all');
Route::post('/register-all', [RegisterAllController::class, 'store'])->name('register.all.submit');

Route::middleware('auth:pembeli')->prefix('profil')->group(function () {
    Route::get('/', [ProfilController::class, 'index'])->name('pembeli.profil');
    Route::post('/update', [ProfilController::class, 'update'])->name('pembeli.profil.update');
    Route::post('/upload-foto', [ProfilController::class, 'uploadFoto'])->name('pembeli.profil.upload_foto');
    Route::post('/alamat', [ProfilController::class, 'tambahAlamat'])->name('pembeli.alamat.tambah');
    Route::post('/alamat/{id}/default', [ProfilController::class, 'setDefaultAlamat'])->name('pembeli.alamat.default');
});

Route::get('/pembeli/pembayaran-gagal/{id}', [\App\Http\Controllers\Pembeli\TransaksiController::class, 'gagalBayar'])
    ->name('pembeli.transaksi.gagalBayar');

Route::get('/pembeli/riwayat', [\App\Http\Controllers\Pembeli\TransaksiController::class, 'riwayat'])
    ->name('pembeli.transaksi.riwayat');

Route::get('/pembeli/riwayat/{id}', [\App\Http\Controllers\Pembeli\TransaksiController::class, 'detail'])
    ->name('pembeli.transaksi.detail');

Route::get('/pembeli/riwayat/{id}/cetak', [\App\Http\Controllers\Pembeli\TransaksiController::class, 'cetakNota'])
    ->name('pembeli.transaksi.cetakNota');

Route::middleware('auth:pembeli')->group(function () {
    Route::get('/profil', [ProfilController::class, 'index'])->name('pembeli.profil');
    Route::get('/profil/edit', [ProfilController::class, 'edit'])->name('pembeli.profil.edit');
    Route::post('/profil/update', [ProfilController::class, 'update'])->name('pembeli.profil.update');
    Route::post('/profil/upload-foto', [ProfilController::class, 'uploadFoto'])->name('pembeli.profil.upload_foto');
    Route::post('/pembeli/rating/{barang_id}', [\App\Http\Controllers\Pembeli\TransaksiController::class, 'beriRating'])
    ->name('pembeli.rating.submit');
});

Route::middleware(['auth:pembeli'])->prefix('pembeli/alamat')->name('pembeli.alamat.')->group(function () {
    Route::get('/create', [\App\Http\Controllers\Pembeli\AlamatController::class, 'create'])->name('create');
    Route::post('/', [\App\Http\Controllers\Pembeli\AlamatController::class, 'store'])->name('store');
});

Route::middleware('auth:pembeli')->prefix('pembeli')->group(function () {
    Route::get('/kelola-alamat', [AlamatController::class, 'index'])->name('pembeli.alamat.index');
    Route::post('/alamat/set-default/{id}', [AlamatController::class, 'setDefault'])->name('pembeli.alamat.setDefault');
});

Route::middleware('auth:pembeli')->prefix('pembeli')->group(function () {
    Route::get('/kelola-alamat', [AlamatController::class, 'index'])->name('pembeli.alamat.index');
    Route::post('/alamat/set-default/{id}', [AlamatController::class, 'setDefault'])->name('pembeli.alamat.setDefault');

    Route::post('/alamat', [AlamatController::class, 'store'])->name('pembeli.alamat.store');
    Route::get('/alamat/{id}/edit', [AlamatController::class, 'edit'])->name('pembeli.alamat.edit');
    Route::put('/alamat/{id}', [AlamatController::class, 'update'])->name('pembeli.alamat.update');
    Route::delete('/alamat/{id}', [AlamatController::class, 'destroy'])->name('pembeli.alamat.destroy');
});

Route::middleware('auth:pembeli')->group(function () {
    Route::post('/keranjang/{barang}', [KeranjangController::class, 'tambah'])->name('keranjang.tambah');
});
Route::get('/keranjang', [KeranjangController::class, 'index'])->name('cart.index');
Route::delete('/keranjang/{id}', [KeranjangController::class, 'hapus'])->name('keranjang.hapus');

Route::post('/diskusi', [DiskusiController::class, 'store'])->middleware('auth:pembeli')->name('diskusi.store');

Route::get('/pembeli/pembayaran', [\App\Http\Controllers\Pembeli\TransaksiController::class, 'pembayaranForm'])
    ->name('pembeli.pembayaran.form');

Route::post('/pembeli/proses-pembayaran', [\App\Http\Controllers\Pembeli\TransaksiController::class, 'prosesPembayaran'])
    ->name('pembeli.transaksi.proses');

Route::get('/pembeli/upload-bukti/{id}', [TransaksiController::class, 'uploadBuktiForm'])
    ->name('pembeli.transaksi.uploadBuktiForm');

// GET form upload bukti
Route::get('/pembeli/upload-bukti/{id}', [\App\Http\Controllers\Pembeli\TransaksiController::class, 'uploadBuktiForm'])
    ->name('pembeli.transaksi.uploadBuktiForm');

// POST submit bukti
Route::post('/pembeli/upload-bukti/{id}', [\App\Http\Controllers\Pembeli\TransaksiController::class, 'submitBuktiTransfer'])
    ->name('pembeli.transaksi.submitBukti');

//notifikasi
Route::post('/pembeli/notifikasi/baca-semua', function () {
    auth('pembeli')->user()->unreadNotifications->markAsRead();
    return back();
})->name('pembeli.notifikasi.baca-semua');

Route::get('/kirim-tes-notifikasi', function () {
    $token = ''; // <-- Ganti dengan token HP kamu
    $title = '🎉 Notifikasi dari Laravel';
    $body = 'Halo, ini notifikasi pertamamu dari ReuseMart!';

    $firebase = new FirebaseMessagingService();
    $firebase->sendToToken($token, $title, $body);

    return '✅ Notifikasi berhasil dikirim!';
});


Route::middleware('auth:penitip')->group(function () {
    Route::get('/penitip/dashboard', [DashboardPenitipController::class, 'index'])->name('penitip.dashboard');
});

Route::middleware('auth:penitip')->get('/penitip/barang/{id}', [BarangController::class, 'show'])->name('penitip.barang.show');

Route::middleware('auth:penitip')->group(function () {
    Route::get('/penitip/barang/{id}', [\App\Http\Controllers\Penitip\BarangPenitipController::class, 'show'])->name('penitip.barang.show');
    Route::post('/penitip/barang/{id}/perpanjang', [\App\Http\Controllers\Penitip\BarangController::class, 'perpanjang'])->name('penitip.barang.perpanjang');
    Route::post('/penitip/barang/{id}/konfirmasi-pengambilan', [\App\Http\Controllers\Penitip\BarangController::class, 'konfirmasiPengambilan'])->name('penitip.barang.konfirmasi-pengambilan');
});

Route::middleware('auth:penitip')->prefix('penitip')->group(function () {
    Route::get('/profil/edit', [ProfilPenitipController::class, 'edit'])->name('penitip.profil.edit');
    Route::post('/profil/update', [ProfilPenitipController::class, 'update'])->name('penitip.profil.update');
});

Route::get('/penitip/barang/riwayat/{id}', [\App\Http\Controllers\Penitip\BarangController::class, 'riwayat'])->name('penitip.barang.riwayat');


Route::get('/login-penitip', [PenitipAuthController::class, 'loginForm'])->name('penitip.login.form');
Route::post('/login-penitip', [PenitipAuthController::class, 'login'])->name('penitip.login');

Route::middleware('auth:penitip')->prefix('penitip')->group(function () {
    Route::get('/profil', [ProfilPenitipController::class, 'edit'])->name('penitip.profil.edit');
    Route::post('/profil', [ProfilPenitipController::class, 'update'])->name('penitip.profil.update');
});
// notifikasi 
Route::post('/penitip/notifikasi/baca-semua', function () {
    auth('penitip')->user()->unreadNotifications->markAsRead();
    return back();
})->name('penitip.notifikasi.baca-semua');


Route::get('/barang/{id}', [BarangController::class, 'show'])->name('barang.show');

Route::middleware(['auth:organisasi'])->group(function () {
    Route::get('/organisasi/dashboard', [OrganisasiController::class, 'index'])->name('organisasi.dashboard');

    Route::get('/organisasi/request-donasi', [RequestDonasiController::class, 'create'])->name('organisasi.request.create');
    Route::post('/organisasi/request-donasi', [RequestDonasiController::class, 'store'])->name('organisasi.request.store');
});

Route::get('/organisasi/edit-profil', [OrganisasiController::class, 'edit'])->name('organisasi.edit');
Route::post('/organisasi/update-profil', [OrganisasiController::class, 'update'])->name('organisasi.update');

Route::post('/organisasi/update-picture', [OrganisasiController::class, 'updateProfilePicture'])
    ->name('organisasi.update.picture')->middleware('auth:organisasi');

Route::middleware(['auth:organisasi'])->prefix('organisasi')->group(function () {
    Route::get('/dashboard', [OrganisasiController::class, 'index'])->name('organisasi.dashboard');

    Route::get('/request-donasi', [RequestDonasiController::class, 'create'])->name('organisasi.request.create');
    Route::post('/request-donasi', [RequestDonasiController::class, 'store'])->name('organisasi.request.store');

    Route::get('/request/{id}/edit', [RequestDonasiController::class, 'edit'])->name('organisasi.request.edit');
    Route::post('/request/{id}/update', [RequestDonasiController::class, 'update'])->name('organisasi.request.update');
    Route::delete('/request/{id}', [RequestDonasiController::class, 'destroy'])->name('organisasi.request.destroy');
});


Route::get('/register-penitip', [PenitipAuthController::class, 'registerForm'])->name('penitip.register.form');
Route::post('/register-penitip', [PenitipAuthController::class, 'register'])->name('penitip.register');

Route::post('/logout-penitip', [PenitipAuthController::class, 'logout'])->name('penitip.logout');
Route::post('/logout-organisasi', [PenitipAuthController::class, 'logout'])->name('organisasi.logout');


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/kategori/baru-masuk', [KategoriController::class, 'baruMasuk'])->name('kategori.baru');
Route::get('/kategori/{id}', [KategoriController::class, 'show'])->name('kategori.show');
Route::get('/barang/{id}', [BarangController::class, 'show'])->name('barang.show');
Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');

Route::get('/login-pembeli', [PembeliAuthController::class, 'loginForm'])->name('pembeli.login.form');
Route::post('/login-pembeli', [PembeliAuthController::class, 'login'])->name('pembeli.login');

Route::get('/register-pembeli', [PembeliAuthController::class, 'registerForm'])->name('pembeli.register.form');
Route::post('/register-pembeli', [PembeliAuthController::class, 'register'])->name('pembeli.register');

Route::post('/logout-pembeli', [PembeliAuthController::class, 'logout'])->name('pembeli.logout');

Route::post('/profil/alamat/{id}/default', [ProfilController::class, 'setDefaultAlamat'])->name('pembeli.alamat.default');


Route::get('/bantuan', function () {
    return view('bantuan');
})->name('bantuan');




// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
