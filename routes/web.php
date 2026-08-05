<?php

use App\Http\Controllers\User\ProductController as PublicProductController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Public product detail page for QR Code Scanning
Route::get('/product/{code}', [PublicProductController::class, 'show'])->name('products.show.public');

// Root redirect logic - users go to user dashboard directly
Route::get('/', function () {
    return redirect()->route('user.dashboard');
});

// Admin entrance - redirects to login if guest, or admin.dashboard if logged in
Route::get('/admin', function () {
    if (Auth::check() && Auth::user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('login');
});

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
require __DIR__.'/user.php';