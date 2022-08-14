<?php

namespace App\Repositories;

use App\Contracts\PostRepositoryInterface;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostRepository extends Repository implements PostRepositoryInterface
{
    protected array $relations = ['user'];

    /**
     * @param  Post  $post
     */
    public function __construct(Post $post)
    {
        parent::__construct($post, $this->relations);
    }

    public function index()
    {
        $query = $this->model;

        if (!empty($this->relations)) {
            $query = $query->with($this->relations);
        }

        return $query->where('publication_date', '<=', now())
                     ->orderBy('publication_date', request()->query('order', 0) ? 'asc' : 'desc')
                     ->paginate()
                     ->withQueryString();;
    }

    public function indexByAuthUser()
    {
        $query = $this->model;

        if (!empty($this->relations)) {
            $query = $query->with($this->relations);
        }

        return $query->where('user_id', Auth::id())
                     ->orderBy('publication_date', request()->query('order', 0) ? 'asc' : 'desc')
                     ->paginate()
                     ->withQueryString();
    }

    public function get(int $id)
    {
        return $this->model->where('publication_date', '<=', now())->findOrFail($id);
    }

    public function getByAuthUser(int $id)
    {
        return $this->model->where('user_id', Auth::id())
                           ->findOrFail($id);
    }
}