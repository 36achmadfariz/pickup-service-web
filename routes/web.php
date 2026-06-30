<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PickupController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KurirController;

// Public - landing page
Route::get('/', function () {
    return view('welcome');
})->name('home');
Route::post('/pickup', [PickupController::class, 'store'])->name('pickup.store')->middleware('throttle:20,10');
Route::get('/pickup/success/{id}', [PickupController::class, 'success'])->name('pickup.success');
Route::get('/pickup/cancel/{id}', [PickupController::class, 'cancelForm'])->name('pickup.cancelForm');
Route::delete('/pickup/cancel/{id}', [PickupController::class, 'cancel'])->name('pickup.cancel');

// Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/assign', [AdminController::class, 'assign'])->name('admin.assign');
    Route::post('/kurir/create', [AdminController::class, 'createKurir'])->name('admin.createKurir');
    Route::get('/search', [AdminController::class, 'search'])->name('admin.search');
    Route::delete('/pickup/{id}', [AdminController::class, 'deletePickup'])->name('admin.deletePickup');
    Route::delete('/kurir/{id}', [AdminController::class, 'deleteKurir'])->name('admin.deleteKurir');
    Route::get('/export', [AdminController::class, 'export'])->name('admin.export');
    Route::get('/kurir', [AdminController::class, 'kurir'])->name('admin.kurir');
    Route::get('/riwayat', [AdminController::class, 'riwayat'])->name('admin.riwayat');
});

// Kurir
Route::middleware(['auth'])->prefix('kurir')->group(function () {
    Route::get('/dashboard', [KurirController::class, 'dashboard'])->name('kurir.dashboard');
    Route::post('/pickup/{id}/status', [KurirController::class, 'updateStatus'])->name('kurir.updateStatus');
    Route::get('/riwayat', [KurirController::class, 'riwayat'])->name('kurir.riwayat');
});
