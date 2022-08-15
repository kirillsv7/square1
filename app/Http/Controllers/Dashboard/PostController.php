<?php

namespace App\Http\Controllers\Dashboard;

use App\Contracts\PostRepositoryInterface;
use App\Contracts\UserRepositoryInterface;
use App\Exceptions\PostNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StoreRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
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
        $userId = Auth::id();
        $page   = request()->query('page', 1);
        $order  = request()->query('order', 0) ? 'asc' : 'desc';

        $posts = $this->postRepository->indexByUser($userId, $page, $order);

        return view('dashboard.post.index', compact('posts'));
    }

    public function create(): View
    {
        return view('dashboard.post.create');
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $data = $request->validated() + ['user_id' => Auth::id()];

        $this->postRepository->store($data);

        return redirect()->route('dashboard.post.index');
    }

    /**
     * @throws PostNotFoundException
     */
    public function show(int $id): View
    {
        $post = $this->postRepository->getByUser($id, Auth::id());

        if ($post === null) {
            throw new PostNotFoundException();
        }

        $user = $this->userRepository->get($post->user_id);

        return view('front.post.show', compact('post', 'user'));
    }
}
