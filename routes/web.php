<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);

// Login routes for Pelanggan
// Login routes for Pelanggan
Route::get('pelanggan/login', [PelangganController::class, 'showLoginForm'])->name('pelanggan.login.form');
Route::post('pelanggan/login', [PelangganController::class, 'login'])->name('pelanggan.login');

// Register routes for Pelanggan
Route::get('/pelanggan/register', [PelangganController::class, 'showRegisterForm'])->name('pelanggan.register');
Route::post('/pelanggan/register', [PelangganController::class, 'register']);

Route::post('pelanggan/logout', [PelangganController::class, 'logout'])->name('pelanggan.logout');

Route::middleware('auth:pelanggan')->group(function () {
    Route::get('pelanggan/dashboard', [PelangganController::class, 'index'])->name('pelanggan.dashboard');
});

Route::get('/laporan/transaksi/{periode}', [TransaksiController::class, 'cetakTransaksi'])->name('laporan.transaksi');
Route::get('/cetak-nota/{id}', [TransaksiController::class, 'cetakNota'])->name('cetak.nota');
