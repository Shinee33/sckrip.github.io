<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function __construct(protected CategoryService $categoryService)
    {
    }

    public function index(Request $request): View
    {
        $categories = $this->categoryService->paginate($request->only('search'), 10);

        return view('admin.categories.index', compact('categories'));
    }

    public function store(StoreCategoryRequest $request): JsonResponse|RedirectResponse
    {
        $category = $this->categoryService->create($request->validated());

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Jenis beras berhasil ditambahkan.',
                'category' => $category,
            ]);
        }

        return redirect()->back()
            ->with('success', 'Jenis beras berhasil ditambahkan.');
    }

    public function update(StoreCategoryRequest $request, Category $category): JsonResponse|RedirectResponse
    {
        $updated = $this->categoryService->update($category, $request->validated());

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Jenis beras berhasil diperbarui.',
                'category' => $category->fresh(),
            ]);
        }

        return redirect()->route('admin.categories.index')
            ->with('success', 'Jenis beras berhasil diperbarui.');
    }

    public function destroy(Request $request, Category $category): JsonResponse|RedirectResponse
    {
        $this->categoryService->delete($category);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Jenis beras berhasil dihapus.',
            ]);
        }

        return redirect()->route('admin.categories.index')
            ->with('success', 'Jenis beras berhasil dihapus.');
    }
}
