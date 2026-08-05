<?php

use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\QrCodeController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Export products & Resource
    Route::get('/products/export', [ProductController::class, 'export'])->name('products.export');
    Route::post('/products/{id}/restore', [ProductController::class, 'restore'])->name('products.restore');
    Route::resource('products', ProductController::class);
    Route::get('/barang', [ProductController::class, 'index']);
    Route::get('/lokasi', [ProductController::class, 'index']);

    // Categories
    Route::resource('categories', CategoryController::class)->except(['create', 'show', 'edit']);
    Route::get('/kategori', [CategoryController::class, 'index']);

    // QR Code Management
    Route::get('/qr-codes', [QrCodeController::class, 'index'])->name('qr.index');
    Route::get('/qrcode', [QrCodeController::class, 'index']);
    Route::get('/qr-codes/{product}/download/svg', [QrCodeController::class, 'downloadSvg'])->name('qr.download.svg');
    Route::get('/qr-codes/{product}/download/png', [QrCodeController::class, 'downloadPng'])->name('qr.download.png');
    Route::get('/qr-codes/{product}/print', [QrCodeController::class, 'print'])->name('qr.print');
    Route::post('/qr-codes/{product}/regenerate', [QrCodeController::class, 'regenerate'])->name('qr.regenerate');

    // Users Management
    Route::resource('users', UserController::class)->except(['create', 'show', 'edit']);

    // Activity Logs
    Route::get('/logs', [ActivityLogController::class, 'index'])->name('logs.index');

    // Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
});
