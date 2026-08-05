<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Services\ActivityLogService;
use App\Services\CategoryService;
use App\Services\ProductService;
use App\Services\QrCodeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ProductController extends Controller
{
    public function __construct(
        protected ProductService $productService,
        protected CategoryService $categoryService,
        protected QrCodeService $qrCodeService,
        protected ActivityLogService $activityLogService
    ) {
    }

    public function index(Request $request): View
    {
        $filters = $request->only(['search', 'category_id', 'status', 'location']);
        $showTrashed = $request->boolean('trashed');

        $products = $showTrashed
            ? $this->productService->paginateTrashed($filters, 10)
            : $this->productService->paginate($filters, 10);

        $categories = $this->categoryService->all();

        return view('admin.products.index', compact('products', 'categories', 'filters', 'showTrashed'));
    }

    public function create(): View
    {
        $categories = $this->categoryService->all();

        return view('admin.products.create', compact('categories'));
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        $product = $this->productService->create(
            $request->validated(),
            $request->file('image')
        );

        return redirect()->route('admin.products.show', $product)
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function show(Product $product): View
    {
        $qrCodeSvg = $this->qrCodeService->generateSvg($product, 240);

        return view('admin.products.show', compact('product', 'qrCodeSvg'));
    }

    public function edit(Product $product): View
    {
        $categories = $this->categoryService->all();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $this->productService->update(
            $product,
            $request->validated(),
            $request->file('image')
        );

        return redirect()->route('admin.products.show', $product)
            ->with('success', 'Data produk berhasil diperbarui.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $this->productService->delete($product);

        return redirect()->route('admin.products.index')
            ->with('success', 'Data beras berhasil dihapus.');
    }

    public function restore(int $id): RedirectResponse
    {
        $this->productService->restore($id);

        return redirect()->route('admin.products.index', ['trashed' => 1])
            ->with('success', 'Data beras berhasil dipulihkan.');
    }

    public function export(): StreamedResponse
    {
        $this->activityLogService->log('export_products', 'Mengunduh laporan produk format CSV/Excel');

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="Inventory_Products_' . date('Y-m-d') . '.csv"',
        ];

        $products = Product::with('category')->get();

        $callback = function () use ($products) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Kode', 'Nama Barang', 'Kategori', 'Merk', 'Serial Number', 'Lokasi', 'Stok', 'Satuan', 'Status', 'Tanggal Masuk']);

            foreach ($products as $p) {
                fputcsv($file, [
                    $p->code,
                    $p->name,
                    $p->category?->name ?? '-',
                    $p->brand ?? '-',
                    $p->serial_number ?? '-',
                    $p->location ?? '-',
                    $p->stock,
                    $p->unit,
                    $p->status?->label() ?? $p->status,
                    $p->entry_date?->format('Y-m-d') ?? '-',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
