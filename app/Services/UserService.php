<?php

namespace App\Services;

use App\Contracts\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(
        protected UserRepositoryInterface $repository,
        protected ActivityLogService $activityLogService
    ) {
    }

    public function paginate(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        return $this->repository->paginate($filters, $perPage);
    }

    public function create(array $data): User
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user = $this->repository->create($data);

        $this->activityLogService->log(
            'create_user',
            "Menambahkan pengguna baru: {$user->name} ({$user->email})",
            $user
        );

        return $user;
    }

    public function update(User $user, array $data): bool
    {
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $updated = $this->repository->update($user, $data);

        if ($updated) {
            $this->activityLogService->log(
                'edit_user',
                "Mengubah data pengguna: {$user->name} ({$user->email})",
                $user
            );
        }

        return $updated;
    }

    public function delete(User $user): bool
    {
        $name = $user->name;
        $email = $user->email;

        $deleted = $this->repository->delete($user);

        if ($deleted) {
            $this->activityLogService->log(
                'delete_user',
                "Menghapus akun pengguna: {$name} ({$email})",
                $user
            );
        }

        return $deleted;
    }
}
