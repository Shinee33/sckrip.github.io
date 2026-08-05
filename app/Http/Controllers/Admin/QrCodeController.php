<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\ActivityLogService;
use App\Services\ProductService;
use App\Services\QrCodeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class QrCodeController extends Controller
{
    public function __construct(
        protected ProductService $productService,
        protected QrCodeService $qrCodeService,
        protected ActivityLogService $activityLogService
    ) {
    }

    public function index(Request $request): View
    {
        $products = $this->productService->paginate($request->only('search'), 12);

        foreach ($products as $product) {
            $product->qr_svg = $this->qrCodeService->generateSvg($product, 160);
        }

        return view('admin.qr.index', compact('products'));
    }

    public function downloadSvg(Product $product): Response
    {
        $this->activityLogService->log('download_qr_svg', "Mengunduh QR Code SVG untuk produk: {$product->name} ({$product->code})", $product);

        $svg = $this->qrCodeService->generateSvg($product, 400);

        return response($svg, 200, [
            'Content-Type' => 'image/svg+xml',
            'Content-Disposition' => 'attachment; filename="QR_' . $product->code . '.svg"',
        ]);
    }

    public function downloadPng(Product $product): Response
    {
        $this->activityLogService->log('download_qr_png', "Mengunduh QR Code PNG untuk produk: {$product->name} ({$product->code})", $product);

        $svg = $this->qrCodeService->generateSvg($product, 400);

        return response($svg, 200, [
            'Content-Type' => 'image/svg+xml',
            'Content-Disposition' => 'attachment; filename="QR_' . $product->code . '.svg"',
        ]);
    }

    public function print(Product $product): View
    {
        $this->activityLogService->log('print_qr', "Mencetak QR Label untuk produk: {$product->name} ({$product->code})", $product);

        $qrSvg = $this->qrCodeService->generateSvg($product, 200);

        return view('admin.qr.print', compact('product', 'qrSvg'));
    }

    public function regenerate(Product $product): RedirectResponse
    {
        $this->activityLogService->log('regenerate_qr', "Membuat ulang QR Code untuk produk: {$product->name} ({$product->code})", $product);

        return back()->with('success', 'QR Code berhasil dibuat ulang.');
    }
}
