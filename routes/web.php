<?php

use App\Http\Controllers\LogDomainController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BarangPinjamanController;
use App\Http\Controllers\BarangRusakController;
use App\Http\Controllers\InventoryItemController;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::group(['middleware' => 'ensure.frontend.requests.are.stateful'], function () {
    Route::post('/login', [AuthController::class, 'auth']);
    Route::get('/barang-masuk', [BarangMasukController::class, 'index']);
    Route::post('/barang-masuk', [BarangMasukController::class, 'store']);

    Route::get('/barang-keluar', [BarangKeluarController::class, 'index']);
    Route::post('/barang-keluar', [BarangKeluarController::class, 'store']);

    Route::get('/barang-pinjaman', [BarangPinjamanController::class, 'index']);
    Route::post('/barang-pinjaman', [BarangPinjamanController::class, 'store']);

    Route::get('/barang-rusak', [BarangRusakController::class, 'index']);
    Route::post('/barang-rusak', [BarangRusakController::class, 'store']);

    Route::get('/input-barang', [InventoryItemController::class, 'index']);
    Route::post('/input-barang', [InventoryItemController::class, 'store']);

    Route::post('/login', [LoginController::class, 'login'])->name('login');
});


Route::get('/log-domain', [LogDomainController::class, 'someMethod']);



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';