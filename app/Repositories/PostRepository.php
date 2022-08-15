<?php

namespace App\Repositories;

use App\Contracts\PostRepositoryInterface;
use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PostRepository implements PostRepositoryInterface
{
    public function __construct(
        protected Post $post,
    ) {
    }

    public function index(int $page, string $order): LengthAwarePaginator
    {
        return $this->post
            ->query()
            ->where('publication_date', '<=', now())
            ->orderBy('publication_date', $order)
            ->paginate()
            ->withQueryString();
    }

    public function indexByUser(int $userId, int $page, string $order): LengthAwarePaginator
    {
        return $this->post
            ->query()
            ->where('user_id', $userId)
            ->orderBy('publication_date', $order)
            ->paginate()
            ->withQueryString();
    }

    public function get(int $id): ?Post
    {
        return $this->post
            ->query()
            ->where('id', $id)
            ->where('publication_date', '<=', now())
            ->first();
    }

    public function getByUser(int $id, int $userId): ?Post
    {
        return $this->post
            ->query()
            ->where('id', $id)
            ->where('user_id', $userId)
            ->first();
    }

    public function store(array $data): Post
    {
        $model = $this->post->newInstance($data);

        $model->save();

        return $model;
    }
}