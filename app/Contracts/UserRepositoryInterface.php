<?php

namespace App\Contracts;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    const LIST_TTL = 60;
    const GET_TTL = 60 * 60;

    public function getList(array $ids): Collection;

    public function get(int $id): ?User;
}