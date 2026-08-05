<?php

namespace App\Services;

use App\Contracts\ActivityLogRepositoryInterface;
use App\Models\ActivityLog;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ActivityLogService
{
    public function __construct(protected ActivityLogRepositoryInterface $repository)
    {
    }

    public function log(string $action, string $description, ?object $subject = null, ?array $properties = null, ?int $userId = null): ActivityLog
    {
        return $this->repository->log($action, $description, $subject, $properties, $userId);
    }

    public function paginate(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->paginate($filters, $perPage);
    }

    public function getLatest(int $limit = 10): Collection
    {
        return $this->repository->getLatest($limit);
    }
}
