<?php

use App\Http\Controllers\anggotaController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\registerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('v1.0')->group(function(){
    Route::post('/login', loginController::class)->name('login');
    Route::post('/register', registerController::class)->name('register');
    Route::middleware('auth:api')->group(function(){
        Route::prefix('anggota')->group(function(){
            Route::post('/', [anggotaController::class, 'index'])->name('slider.list');
            Route::post('/create', [anggotaController::class, 'store']);
            Route::post('/show', [anggotaController::class, 'show']);
            Route::post('/update', [anggotaController::class, 'update']);
            Route::delete('/destroy', [anggotaController::class, 'destroy']);
        });
    });
});
