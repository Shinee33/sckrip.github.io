<?php

namespace App\Services;

use App\Contracts\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductService
{
    public function __construct(
        protected ProductRepositoryInterface $repository,
        protected ActivityLogService $activityLogService,
        protected QrCodeService $qrCodeService
    ) {
    }

    public function paginate(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        return $this->repository->paginate($filters, $perPage);
    }

    public function paginateTrashed(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        return $this->repository->paginateTrashed($filters, $perPage);
    }

    public function findByUuid(string $uuid): ?Product
    {
        return $this->repository->findByUuid($uuid);
    }

    public function findByCode(string $code): ?Product
    {
        return $this->repository->findByCode($code);
    }

    public function findById(int $id): ?Product
    {
        return $this->repository->findById($id);
    }

    public function create(array $data, ?object $imageFile = null): Product
    {
        if ($imageFile) {
            $data['image'] = $imageFile->store('products', 'public');
        }

        $data['slug'] = Str::slug($data['name']) . '-' . Str::random(4);
        $data['created_by'] = auth()->id();
        $data['updated_by'] = auth()->id();

        $product = $this->repository->create($data);

        $this->activityLogService->log(
            'create_product',
            "Menambahkan produk baru: {$product->name} ({$product->code})",
            $product,
            ['code' => $product->code, 'stock' => $product->stock]
        );

        return $product;
    }

    public function update(Product $product, array $data, ?object $imageFile = null): bool
    {
        if ($imageFile) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $imageFile->store('products', 'public');
        }

        if (isset($data['name']) && $data['name'] !== $product->name) {
            $data['slug'] = Str::slug($data['name']) . '-' . Str::random(4);
        }

        $data['updated_by'] = auth()->id();

        $updated = $this->repository->update($product, $data);

        if ($updated) {
            $this->activityLogService->log(
                'edit_product',
                "Mengubah data produk: {$product->name} ({$product->code})",
                $product,
                $data
            );
        }

        return $updated;
    }

    public function delete(Product $product): bool
    {
        $name = $product->name;
        $code = $product->code;
        $deleted = $this->repository->delete($product);

        if ($deleted) {
            $this->activityLogService->log(
                'delete_product',
                "Menghapus produk (Soft Delete): {$name} ({$code})",
                $product
            );
        }

        return $deleted;
    }

    public function restore(int $id): bool
    {
        $restored = $this->repository->restore($id);

        if ($restored) {
            $product = $this->repository->findById($id);
            $this->activityLogService->log(
                'restore_product',
                "Mengembalikan produk dari tempat sampah: {$product?->name} ({$product?->code})",
                $product
            );
        }

        return $restored;
    }

    public function forceDelete(int $id): bool
    {
        return $this->repository->forceDelete($id);
    }

    public function getDashboardStats(): array
    {
        return $this->repository->getDashboardStats();
    }

    public function getLatest(int $limit = 10): Collection
    {
        return $this->repository->getLatest($limit);
    }
}
