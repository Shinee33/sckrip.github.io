<?php

namespace App\Services;

use App\Contracts\CategoryRepositoryInterface;
use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class CategoryService
{
    public function __construct(
        protected CategoryRepositoryInterface $repository,
        protected ActivityLogService $activityLogService
    ) {
    }

    public function all(): Collection
    {
        return $this->repository->all();
    }

    public function paginate(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        return $this->repository->paginate($filters, $perPage);
    }

    public function create(array $data): Category
    {
        $data['slug'] = Str::slug($data['name']);
        $category = $this->repository->create($data);

        $this->activityLogService->log(
            'create_category',
            "Menambahkan kategori baru: {$category->name}",
            $category
        );

        return $category;
    }

    public function update(Category $category, array $data): bool
    {
        if (isset($data['name'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $updated = $this->repository->update($category, $data);

        if ($updated) {
            $this->activityLogService->log(
                'edit_category',
                "Mengubah data kategori: {$category->name}",
                $category
            );
        }

        return $updated;
    }

    public function delete(Category $category): bool
    {
        $name = $category->name;
        $deleted = $this->repository->delete($category);

        if ($deleted) {
            $this->activityLogService->log(
                'delete_category',
                "Menghapus kategori: {$name}",
                $category
            );
        }

        return $deleted;
    }
}
