<?php

use App\Http\Controllers\CarOwner;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Mechanic;
use App\Http\Controllers\Auth;
use App\Http\Controllers\IndexController;
use App\Http\Middleware\AdminOnlyMiddleware;
use App\Http\Middleware\CarOwnerOnlyMiddleware;
use App\Http\Middleware\MechanicOnlyMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', IndexController::class);

//* basic auth
Route::post('/login', [Auth\AuthController::class, 'login'])->name('auth.login');
Route::middleware('auth:sanctum')->group(function() {
    Route::get('/logged-user', [Auth\AuthController::class, 'loggedUser'])->name('auth.logged-user');
    Route::post('/logout', [Auth\AuthController::class, 'logout'])->name('auth.logout');
});

//* admin
Route::middleware(['auth:sanctum', AdminOnlyMiddleware::class])->prefix('/admin')->name('admin.')->group(function() {
    //* service
    Route::get('/services', [Admin\Service\ServiceController::class, 'index'])->name('service.index');
    Route::get('/services/{id}', [Admin\Service\ServiceController::class, 'show'])->name('service.show');
    Route::post('/services', [Admin\Service\ServiceController::class, 'store'])->name('service.store');
    Route::put('/services/{id}', [Admin\Service\ServiceController::class, 'update'])->name('service.update');
    Route::delete('/services/{id}', [Admin\Service\ServiceController::class, 'destroy'])->name('service.destroy');

    //* user
    Route::get('/users', [Admin\User\UserController::class, 'index'])->name('user.index');
    Route::post('/users', [Admin\User\UserController::class, 'store'])->name('user.store');
    Route::delete('/users/{id}', [Admin\User\UserController::class, 'destroy'])->name('user.destroy');

    //* repair invoice
    Route::get('/repairs/{id}/invoices', [Admin\Repair\RepairInvoiceController::class, 'show'])->name('repair.repair-invoice.show');
    Route::post('/repairs/{id}/invoices/send', [Admin\Repair\RepairInvoiceController::class, 'send'])->name('repair.repair-invoice.send');
    Route::post('/repairs/{id}/invoices', [Admin\Repair\RepairInvoiceController::class, 'store'])->name('repair.repair-invoice.store');

    //* repair job
    Route::get('/repairs/{id}/jobs', [Admin\Repair\RepairJobController::class, 'index'])->name('repair.repair-job.index');
    Route::post('/repairs/{id}/jobs', [Admin\Repair\RepairJobController::class, 'store'])->name('repair.repair-job.store');
    Route::put('/repairs/{id}/jobs/{repair_job_id}', [Admin\Repair\RepairJobController::class, 'update'])->name('repair.repair-job.update');
    Route::delete('/repairs/{id}/jobs/{repair_job_id}', [Admin\Repair\RepairJobController::class, 'destroy'])->name('repair.repair-job.destroy');

    //* repair
    Route::get('/repairs', [Admin\Repair\RepairController::class, 'index'])->name('repair.index');
    Route::get('/repairs/{id}', [Admin\Repair\RepairController::class, 'show'])->name('repair.show');
    Route::post('/repairs', [Admin\Repair\RepairController::class, 'store'])->name('repair.store');
    Route::put('/repairs/{id}', [Admin\Repair\RepairController::class, 'update'])->name('repair.update');
    Route::delete('/repairs/{id}', [Admin\Repair\RepairController::class, 'destroy'])->name('repair.destroy');
});

//* mechanic
Route::middleware(['auth:sanctum', MechanicOnlyMiddleware::class])->prefix('/mechanic')->name('mechanic.')->group(function() {
    Route::get('/jobs', [Mechanic\Job\JobController::class, 'index'])->name('job.index');
    Route::get('/jobs/{id}', [Mechanic\Job\JobController::class, 'show'])->name('job.show');
    Route::put('/jobs/{id}', [Mechanic\Job\JobController::class, 'update'])->name('job.update');
});

//* car-owner
Route::middleware(['auth:sanctum', CarOwnerOnlyMiddleware::class])->prefix('/car-owner')->name('car-owner.')->group(function() {
    //* repair
    Route::get('/repairs', [CarOwner\Repair\RepairController::class, 'index'])->name('repair.index');
    Route::get('/repairs/{id}', [CarOwner\Repair\RepairController::class, 'show'])->name('repair.show');
});
