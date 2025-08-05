<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);

Route::get('/laporan/transaksi/{periode}', [TransaksiController::class, 'cetakTransaksi'])->name('laporan.transaksi');
