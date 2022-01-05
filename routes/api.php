<?php

use App\Http\Controllers\BahanBakuController;
use App\Http\Controllers\PembelianBahanBakuController;
use App\Http\Controllers\RequestPembelianBahanBakuController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::get('/bahan-baku', [BahanBakuController::class, 'index']);
// Route::get('/bahan-baku/{id}', [BahanBakuController::class, 'show']);
// Route::get('/bahan-baku', [BahanBakuController::class, 'getByCategory']);

Route::resource('/bahan-baku', BahanBakuController::class);
Route::resource('/pembelian-bahan-baku', PembelianBahanBakuController::class);
Route::resource('/request-pembelian-bahan-baku', RequestPembelianBahanBakuController::class);