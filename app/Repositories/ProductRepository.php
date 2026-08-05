<?php

namespace App\Repositories;

use App\Contracts\ProductRepositoryInterface;
use App\Enums\ProductStatus;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository implements ProductRepositoryInterface
{
    public function paginate(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        $query = Product::with(['category', 'creator'])->latest();

        if (!empty($filters['search'])) {
            $query->search($filters['search']);
        }

        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['location'])) {
            $query->where('location', 'like', "%{$filters['location']}%");
        }

        return $query->paginate($perPage)->withQueryString();
    }

    public function paginateTrashed(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        $query = Product::onlyTrashed()->with(['category', 'creator'])->latest();

        if (!empty($filters['search'])) {
            $query->search($filters['search']);
        }

        return $query->paginate($perPage)->withQueryString();
    }

    public function findById(int $id): ?Product
    {
        return Product::with(['category', 'creator', 'editor'])->find($id);
    }

    public function findByUuid(string $uuid): ?Product
    {
        return Product::with(['category', 'creator', 'editor'])->where('uuid', $uuid)->first();
    }

    public function findByCode(string $code): ?Product
    {
        return Product::with(['category', 'creator', 'editor'])->where('code', $code)->first();
    }

    public function create(array $data): Product
    {
        return Product::create($data);
    }

    public function update(Product $product, array $data): bool
    {
        return $product->update($data);
    }

    public function delete(Product $product): bool
    {
        return (bool) $product->delete();
    }

    public function restore(int $id): bool
    {
        $product = Product::onlyTrashed()->find($id);
        return $product ? (bool) $product->restore() : false;
    }

    public function forceDelete(int $id): bool
    {
        $product = Product::onlyTrashed()->find($id);
        return $product ? (bool) $product->forceDelete() : false;
    }

    public function getDashboardStats(): array
    {
        return [
            'total_products' => Product::count(),
            'active_products' => Product::where('status', ProductStatus::ACTIVE)->count(),
            'damaged_products' => Product::where('status', ProductStatus::DAMAGED)->count(),
            'borrowed_products' => Product::where('status', ProductStatus::BORROWED)->count(),
            'out_of_stock_products' => Product::where('stock', 0)->orWhere('status', ProductStatus::OUT_OF_STOCK)->count(),
            'total_categories' => \App\Models\Category::count(),
        ];
    }

    public function getLatest(int $limit = 10): Collection
    {
        return Product::with('category')->latest()->take($limit)->get();
    }
}
