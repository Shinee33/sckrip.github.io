<?php

namespace App\Contracts;

use App\Models\ActivityLog;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface ActivityLogRepositoryInterface
{
    public function log(string $action, string $description, ?object $subject = null, ?array $properties = null, ?int $userId = null): ActivityLog;
    public function paginate(array $filters = [], int $perPage = 15): LengthAwarePaginator;
    public function getLatest(int $limit = 10): Collection;
}
