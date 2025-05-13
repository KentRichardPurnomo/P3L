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
use App\Http\Controllers\Owner\OwnerController;

Route::get('/login', [LoginUniversalController::class, 'showLoginForm'])->name('login.universal');
Route::post('/login', [LoginUniversalController::class, 'login'])->name('login.universal.submit');

// Dashboard pegawai (blank sementara)
Route::get('/pegawai/dashboard', [PegawaiController::class, 'dashboard'])->name('pegawai.dashboard')->middleware('auth:pegawai');


//admin
Route::prefix('admin')->middleware(['auth:pegawai', 'admin.only'])->group(function () {
    Route::get('/organisasi', [AdminOrganisasiController::class, 'index'])->name('admin.organisasi.index');
    Route::get('/organisasi/{username}/edit', [AdminOrganisasiController::class, 'edit'])->name('admin.organisasi.edit');
    Route::put('/organisasi/{username}', [AdminOrganisasiController::class, 'update'])->name('admin.organisasi.update');
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

// Owner
Route::prefix('owner')->name('owner.')->middleware('auth:owner')->group(function () {
    Route::get('/dashboard', [OwnerController::class, 'index'])->name('dashboard');
    Route::get('/history-donasi/{organisasi_id}', [OwnerController::class, 'historyDonasiOrganisasi'])
        ->name('history.donasi')
        ->middleware('auth:owner');
});


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

Route::middleware('auth:pembeli')->group(function () {
    Route::get('/profil', [ProfilController::class, 'index'])->name('pembeli.profil');
    Route::get('/profil/edit', [ProfilController::class, 'edit'])->name('pembeli.profil.edit');
    Route::post('/profil/update', [ProfilController::class, 'update'])->name('pembeli.profil.update');
    Route::post('/profil/upload-foto', [ProfilController::class, 'uploadFoto'])->name('pembeli.profil.upload_foto');
});

Route::middleware('auth:penitip')->group(function () {
    Route::get('/penitip/dashboard', [DashboardPenitipController::class, 'index'])->name('penitip.dashboard');
});

Route::middleware('auth:penitip')->get('/penitip/barang/{id}', [BarangController::class, 'show'])->name('penitip.barang.show');

Route::middleware('auth:penitip')->group(function () {
    Route::get('/penitip/barang/{id}', [\App\Http\Controllers\Penitip\BarangPenitipController::class, 'show'])->name('penitip.barang.show');
});


Route::middleware('auth:penitip')->prefix('penitip')->group(function () {
    Route::get('/profil/edit', [ProfilPenitipController::class, 'edit'])->name('penitip.profil.edit');
    Route::post('/profil/update', [ProfilPenitipController::class, 'update'])->name('penitip.profil.update');
});

Route::get('/login-penitip', [PenitipAuthController::class, 'loginForm'])->name('penitip.login.form');
Route::post('/login-penitip', [PenitipAuthController::class, 'login'])->name('penitip.login');

Route::middleware('auth:penitip')->prefix('penitip')->group(function () {
    Route::get('/profil', [ProfilPenitipController::class, 'edit'])->name('penitip.profil.edit');
    Route::post('/profil', [ProfilPenitipController::class, 'update'])->name('penitip.profil.update');
});

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
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
Route::post('/diskusi', [DiskusiController::class, 'store'])->name('diskusi.store')->middleware('auth');

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
