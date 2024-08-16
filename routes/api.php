<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\BarangPinjamanController;
use App\Http\Controllers\BarangRusakController;
use App\Http\Controllers\InventoryItemController;

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
Route::post('/login', [AuthController::class, 'auth']);
Route::get('/barang-masuk', [BarangMasukController::class, 'index']);
Route::post('/barang-masuk', [BarangMasukController::class, 'store']);
Route::put('/barang-masuk/{id}', [BarangMasukController::class, 'update']);
Route::delete('/barang-masuk/{id}', [BarangMasukController::class, 'destroy']);
Route::get('/barang-masuk/{id}', [BarangMasukController::class, 'show']);

//Barang-Keluar
Route::get('/barang-keluar', [BarangKeluarController::class, 'index']);
Route::post('/barang-keluar', [BarangKeluarController::class, 'store']);

//Barang-Pinjaman
Route::get('/barang-pinjaman', [BarangPinjamanController::class, 'index']);
Route::post('/barang-pinjaman', [BarangPinjamanController::class, 'store']);

//Barang-Rusak
Route::get('/barang-rusak', [BarangRusakController::class, 'index']);
Route::post('/barang-rusak', [BarangRusakController::class, 'store']);

//Input-Barang
Route::get('/input-barang', [InventoryItemController::class, 'index']);
Route::post('/input-barang', [InventoryItemController::class, 'store']);
Route::put('/input-barang/{id}', [InventoryItemController::class, 'update']);
Route::delete('/input-barang/{id}', [InventoryItemController::class, 'destroy']);
Route::get('/input-barang/{id}', [InventoryItemController::class, 'show']);