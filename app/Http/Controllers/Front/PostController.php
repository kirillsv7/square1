<?php

namespace App\Http\Controllers\Front;

use App\Contracts\PostRepositoryInterface;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    /**
     * @param  PostRepositoryInterface  $repository
     */
    public function __construct(
        protected PostRepositoryInterface $repository
    ) {
    }

    public function index()
    {
        $posts = $this->repository->index();

        return view('front.post.index', compact('posts'));
    }

    public function show(int $id)
    {
        $post = $this->repository->get($id);

        return view('front.post.show', compact('post'));
    }
}
