<?php

namespace App\Cache;

use App\Contracts\UserRepositoryInterface;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Collection;

class UserCache implements UserRepositoryInterface
{
    public function __construct(
        protected UserRepository $repository,
        protected Cache $cache
    ) {
    }

    public function getList(array $ids): Collection
    {
        $key = 'user_list_' . implode('_', $ids);

        return $this->cache::tags('users')->remember($key, self::LIST_TTL, function () use ($ids) {
            return $this->repository->getList($ids);
        });
    }

    public function get(int $id): ?User
    {
        $key = 'user_get_' . $id;

        return $this->cache::tags('user')->remember($key, self::GET_TTL, function () use ($id) {
            return $this->repository->get($id);
        });
    }

}