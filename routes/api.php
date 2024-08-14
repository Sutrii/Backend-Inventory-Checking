<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\BarangPinjamanController;
use App\Http\Controllers\BarangRusakController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthController::class, 'auth']);
Route::get('public-post-list', [PostController::class, 'postList']);

//Barang-Masuk
Route::get('/barang-masuk', [BarangMasukController::class, 'index']);
Route::post('/barang-masuk', [BarangMasukController::class, 'store']);

//Barang-Keluar
Route::get('/barang-keluar', [BarangKeluarController::class, 'index']);
Route::post('/barang-keluar', [BarangKeluarController::class, 'store']);

//Barang-Pinjaman
Route::get('/barang-pinjaman', [BarangPinjamanController::class, 'index']);
Route::post('/barang-pinjaman', [BarangPinjamanController::class, 'store']);

//Barang-Rusak
Route::get('/barang-rusak', [BarangRusakController::class, 'index']);
Route::post('/barang-rusak', [BarangRusakController::class, 'store']);