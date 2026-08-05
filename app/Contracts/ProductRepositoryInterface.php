<?php

namespace App\Contracts;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface ProductRepositoryInterface
{
    public function paginate(array $filters = [], int $perPage = 10): LengthAwarePaginator;
    public function paginateTrashed(array $filters = [], int $perPage = 10): LengthAwarePaginator;
    public function findById(int $id): ?Product;
    public function findByUuid(string $uuid): ?Product;
    public function findByCode(string $code): ?Product;
    public function create(array $data): Product;
    public function update(Product $product, array $data): bool;
    public function delete(Product $product): bool;
    public function restore(int $id): bool;
    public function forceDelete(int $id): bool;
    public function getDashboardStats(): array;
    public function getLatest(int $limit = 10): Collection;
}
