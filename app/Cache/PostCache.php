<?php

namespace App\Cache;

use App\Contracts\PostRepositoryInterface;
use App\Models\Post;
use App\Repositories\PostRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class PostCache implements PostRepositoryInterface
{
    public function __construct(
        protected PostRepository $repository,
        protected Cache $cache
    ) {
    }

    public function index(int $page, string $order): LengthAwarePaginator
    {
        $key = 'post_index'
            . '_page_' . $page
            . '_order_' . $order;

        return $this->cache::tags('posts')->remember($key, self::LIST_TTL, function () use ($page, $order) {
            return $this->repository->index($page, $order);
        });
    }

    public function indexByUser(int $userId, int $page, string $order): LengthAwarePaginator
    {
        $key = 'post_index'
            . '_by_user_' . $userId
            . '_page_' . $page
            . '_order_' . $order;

        return $this->cache::tags('posts')->remember($key, self::LIST_TTL, function () use ($userId, $page, $order) {
            return $this->repository->indexByUser($userId, $page, $order);
        });
    }

    public function get(int $id): ?Post
    {
        $key = 'post_show_' . $id;

        return $this->cache::tags('post')->remember($key, self::GET_TTL, function () use ($id) {
            return $this->repository->get($id);
        });
    }

    public function getByUser(int $id, int $userId): ?Post
    {
        $key = 'post_show_' . $id
            . '_by_user_' . $userId;

        return $this->cache::tags('post')->remember($key, self::GET_TTL, function () use ($id, $userId) {
            return $this->repository->getByUser($id, $userId);
        });
    }

    public function store($data): Post
    {
        $this->cache::tags('posts')->flush();

        return $this->repository->store($data);
    }
}