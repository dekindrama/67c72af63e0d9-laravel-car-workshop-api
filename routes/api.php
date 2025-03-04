<?php

use App\Http\Controllers\Admin\Service\ServiceController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Middleware\AdminOnlyMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//* basic auth
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::middleware('auth:sanctum')->group(function() {
    Route::get('/logged-user', [AuthController::class, 'loggedUser'])->name('auth.logged-user');
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
});

//* admin
Route::middleware(['auth:sanctum', AdminOnlyMiddleware::class])->prefix('/admin')->group(function() {
    Route::get('/services', [ServiceController::class, 'index'])->name('service.index');
    Route::post('/services', [ServiceController::class, 'store'])->name('service.store');
    Route::put('/services/{id}', [ServiceController::class, 'update'])->name('service.update');
    Route::delete('/services/{id}', [ServiceController::class, 'destroy'])->name('service.destroy');
});

//* mechanic

//* car-owner
