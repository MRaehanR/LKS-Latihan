<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BahanBakuController;
use App\Http\Controllers\PembelianBahanBakuController;
use App\Http\Controllers\RequestPembelianBahanBakuController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

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

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {
    Route::resource('/bahan-baku', BahanBakuController::class);
    Route::resource('/pembelian-bahan-baku', PembelianBahanBakuController::class);
    Route::resource('/request-pembelian-bahan-baku', RequestPembelianBahanBakuController::class);

    Route::get('user', [AuthController::class, 'index']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::put('user/{id}', [AuthController::class, 'update']);
    Route::delete('user/{id}', [AuthController::class, 'delete']);
});
