<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PersonController;
use App\Http\Controllers\Api\DestinationsController;
use App\Http\Controllers\Api\HotelsController;
use App\Http\Controllers\Api\PaketsController;
use App\Http\Controllers\Api\TransportsController;

use App\Models\Hotels;

// Route untuk person
Route::resource('/person', PersonController::class);

// Route untuk destinations
Route::resource('/destinations', DestinationsController::class);
Route::resource('/hotels', HotelsController::class);
Route::resource('/transports', TransportsController::class);
Route::resource('/pakets', PaketsController::class);

// Route user (untuk autentikasi dengan Sanctum, jika dibutuhkan)
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
