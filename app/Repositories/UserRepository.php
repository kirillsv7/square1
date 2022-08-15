<?php

namespace App\Repositories;

use App\Contracts\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(
        protected User $user
    ) {
    }

    public function getList(array $ids): Collection
    {
        return $this->user
            ->query()
            ->whereIn('id', $ids)
            ->get();
    }

    public function get(int $id): ?User
    {
        return $this->user
            ->query()
            ->where('id', $id)
            ->first();
    }
}