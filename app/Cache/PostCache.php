<?php

namespace App\Cache;

use App\Contracts\PostRepositoryInterface;
use App\Repositories\PostRepository;
use Illuminate\Support\Facades\Auth;

class PostCache extends Cache implements PostRepositoryInterface
{

    public function __construct(PostRepository $repository)
    {
        parent::__construct($repository);
    }

    public function index()
    {
        $key = 'post_index'
            . '_page_' . request()->query('page', 1)
            . '_order_' . request()->query('order', 0);

        return $this->cache::tags('posts')->remember($key, self::TTL, function () {
            return $this->repository->index();
        });
    }

    public function indexByAuthUser()
    {
        $key = 'post_index'
            . '_page_' . request()->query('page', 1)
            . '_order_' . request()->query('order', 0)
            . '_by_user_' . Auth::id();

        return $this->cache::tags('posts')->remember($key, self::TTL, function () {
            return $this->repository->indexByAuthUser();
        });
    }

    public function get(int $id)
    {
        $key = 'post_show_' . $id;

        return $this->cache::tags('post')->remember($key, self::TTL, function () use ($id) {
            return $this->repository->get($id);
        });
    }

    public function getByAuthUser(int $id)
    {
        $key = 'post_show_' . $id
            . '_by_user_' . Auth::id();

        return $this->cache::tags('post')->remember($key, self::TTL, function () use ($id) {
            return $this->repository->getByAuthUser($id);
        });
    }

    public function store($data)
    {
        $this->cache::tags('posts')->flush();;

        return $this->repository->store($data);
    }
}