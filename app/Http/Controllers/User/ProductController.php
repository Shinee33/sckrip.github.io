<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\CategoryService;
use App\Services\ProductService;
use App\Services\QrCodeService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(
        protected ProductService $productService,
        protected CategoryService $categoryService,
        protected QrCodeService $qrCodeService
    ) {
    }

    public function index(Request $request): View
    {
        $filters = $request->only(['search', 'category_id', 'status', 'location']);
        $products = $this->productService->paginate($filters, 12);
        $categories = $this->categoryService->all();

        return view('user.products.index', compact('products', 'categories', 'filters'));
    }

    public function show(string $code): View
    {
        // Allow lookup by code or uuid
        $product = $this->productService->findByCode($code)
            ?? $this->productService->findByUuid($code)
            ?? Product::where('id', $code)->firstOrFail();

        $qrCodeSvg = $this->qrCodeService->generateSvg($product, 200);

        return view('user.products.show', compact('product', 'qrCodeSvg'));
    }
}
