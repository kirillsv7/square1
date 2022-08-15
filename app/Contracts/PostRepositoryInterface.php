<?php

namespace App\Contracts;

use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PostRepositoryInterface
{
    const LIST_TTL = 60;
    const GET_TTL = 60 * 60;

    public function index(int $page, string $order): LengthAwarePaginator;

    public function indexByUser(int $userId, int $page, string $order): LengthAwarePaginator;

    public function get(int $id): ?Post;

    public function getByUser(int $id, int $userId): ?Post;

    public function store(array $data): Post;
}