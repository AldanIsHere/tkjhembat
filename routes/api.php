<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BarangApiController;

Route::middleware('api')->group(function () {
    Route::get('/barang', [BarangApiController::class, 'index']);
    Route::post('/barang', [BarangApiController::class, 'store']);
    Route::get('/barang/{id}', [BarangApiController::class, 'show']);
    Route::put('/barang/{id}', [BarangApiController::class, 'update']);
    Route::delete('/barang/{id}', [BarangApiController::class, 'destroy']);
});
