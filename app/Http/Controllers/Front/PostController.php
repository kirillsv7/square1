<?php

namespace App\Http\Controllers\Front;

use App\Contracts\PostRepositoryInterface;
use App\Contracts\UserRepositoryInterface;
use App\Exceptions\PostNotFoundException;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class PostController extends Controller
{
    public function __construct(
        protected PostRepositoryInterface $postRepository,
        protected UserRepositoryInterface $userRepository
    ) {
    }

    public function index(): View
    {
        $page  = request()->query('page', 1);
        $order = request()->query('order', 0) ? 'asc' : 'desc';

        $posts = $this->postRepository->index($page, $order);

        $userIds = $posts->pluck('user_id')->unique()->toArray();

        $users = $this->userRepository->getList($userIds);

        return view('front.post.index', compact('posts', 'users'));
    }

    /**
     * @throws PostNotFoundException
     */
    public function show(int $id): View
    {
        $post = $this->postRepository->get($id);

        if ($post === null) {
            throw new PostNotFoundException();
        }

        $user = $this->userRepository->get($post->user_id);

        return view('front.post.show', compact('post', 'user'));
    }
}
