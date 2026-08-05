<?php

namespace App\Repositories;

use App\Contracts\ActivityLogRepositoryInterface;
use App\Models\ActivityLog;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ActivityLogRepository implements ActivityLogRepositoryInterface
{
    public function log(string $action, string $description, ?object $subject = null, ?array $properties = null, ?int $userId = null): ActivityLog
    {
        return ActivityLog::create([
            'user_id' => $userId ?? auth()->id(),
            'action' => $action,
            'description' => $description,
            'subject_type' => $subject ? get_class($subject) : null,
            'subject_id' => $subject?->id ?? null,
            'properties' => $properties,
            'ip_address' => request()->ip(),
        ]);
    }

    public function paginate(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = ActivityLog::with(['user', 'subject'])->latest();

        if (!empty($filters['search'])) {
            $term = $filters['search'];
            $query->where(function ($q) use ($term) {
                $q->where('action', 'like', "%{$term}%")
                  ->orWhere('description', 'like', "%{$term}%")
                  ->orWhereHas('user', fn ($uQ) => $uQ->where('name', 'like', "%{$term}%"));
            });
        }

        if (!empty($filters['action'])) {
            $query->where('action', $filters['action']);
        }

        return $query->paginate($perPage)->withQueryString();
    }

    public function getLatest(int $limit = 10): Collection
    {
        return ActivityLog::with('user')->latest()->take($limit)->get();
    }
}
