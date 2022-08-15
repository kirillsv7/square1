<?php

namespace App\Http\Controllers\Front;

use App\Contracts\PostRepositoryInterface;
use App\Exceptions\PostNotFoundException;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

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

    /**
     * @throws PostNotFoundException
     */
    public function show(int $id): View
    {
        $post = $this->repository->get($id);

        if ($post === null) {
            throw new PostNotFoundException();
        }

        return view('front.post.show', compact('post'));
    }
}
