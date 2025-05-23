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
Route::post('/lupa-password-penitip', [PenitipAuthController::class, 'lupaPassword'])->name('penitip.lupa.password');

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

Route::get('/register-penitip', [PenitipAuthController::class, 'registerForm'])->name('penitip.register.form');
Route::post('/register-penitip', [PenitipAuthController::class, 'register'])->name('penitip.register');

Route::post('/logout-penitip', [PenitipAuthController::class, 'logout'])->name('penitip.logout');


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/kategori/{id}', [KategoriController::class, 'show'])->name('kategori.show');
Route::get('/barang/{id}', [BarangController::class, 'show'])->name('barang.show');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
Route::post('/diskusi', [DiskusiController::class, 'store'])->name('diskusi.store')->middleware('auth');

Route::get('/login-pembeli', [PembeliAuthController::class, 'loginForm'])->name('pembeli.login.form');
Route::post('/login-pembeli', [PembeliAuthController::class, 'login'])->name('pembeli.login');
Route::post('/lupa-password-pembeli', [PembeliAuthController::class, 'lupaPassword'])->name('pembeli.lupa.password');
Route::get('/reset-password-pembeli', [PembeliAuthController::class, 'resetPasswordForm'])->name('pembeli.reset.form');
Route::post('/reset-password-pembeli', [PembeliAuthController::class, 'resetPassword'])->name('pembeli.reset');



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
