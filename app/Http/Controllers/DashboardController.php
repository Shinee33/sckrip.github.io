<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'products' => Schema::hasTable('products') ? Product::count() : 0,
            'active_products' => Schema::hasTable('products') ? Product::where('status', 'active')->count() : 0,
            'low_stock_products' => 0,
        ];

        return view('dashboard.index', compact('stats'));
    }
}
