<?php

namespace App\Http\Controllers\Front;

use App\Contracts\PostRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PostController extends Controller
{
    public function __construct(
        protected PostRepositoryInterface $repository
    ) {
    }

    public function index(): View
    {
        $page  = request()->query('page', 1);
        $order = request()->query('order', 0) ? 'asc' : 'desc';

        $posts = $this->repository->index($page, $order);

        return view('front.post.index', compact('posts'));
    }

    public function show(int $id): View
    {
        if (!$post = $this->repository->get($id)) {
            throw (new ModelNotFoundException)->setModel(Post::class, [$id]);
        }

        return view('front.post.show', compact('post'));
    }
}
