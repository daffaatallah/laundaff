<?php

use App\Http\Controllers\LaundryController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LaundryController::class, 'showLogin']);
Route::get('/login', [LaundryController::class, 'showLogin'])->name('login');
Route::post('/login', [LaundryController::class, 'login'])->name('login.post');
Route::get('/logout', [LaundryController::class, 'logout'])->name('logout');

Route::get('/dashboard', [LaundryController::class, 'dashboard'])->name('dashboard');

Route::get('/layanan', [LaundryController::class, 'layanan'])->name('layanan');
Route::post('/layanan', [LaundryController::class, 'storeLayanan'])->name('layanan.store');
Route::put('/layanan/{id}', [LaundryController::class, 'updateLayanan'])->name('layanan.update');
Route::delete('/layanan/{id}', [LaundryController::class, 'destroyLayanan'])->name('layanan.destroy');

Route::get('/transaksi', [LaundryController::class, 'transaksi'])->name('transaksi');
Route::post('/transaksi', [LaundryController::class, 'storeTransaksi'])->name('transaksi.store');
Route::patch('/transaksi/{id}/selesai', [LaundryController::class, 'selesaikanTransaksi'])->name('transaksi.selesai');