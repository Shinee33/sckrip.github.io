<?php

use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\ProductController;
use App\Http\Controllers\User\QrScannerController;
use Illuminate\Support\Facades\Route;

// User routes - publicly accessible without login
Route::get('/dashboard', [DashboardController::class, 'index'])->name('user.dashboard');
Route::get('/catalog', [ProductController::class, 'index'])->name('user.products.index');
Route::get('/scan-qr', [QrScannerController::class, 'index'])->name('user.scan');