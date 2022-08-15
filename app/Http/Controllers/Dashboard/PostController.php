<?php

namespace App\Http\Controllers\Dashboard;

use App\Contracts\PostRepositoryInterface;
use App\Exceptions\PostNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StoreRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;

class PostController extends Controller
{
    public function __construct(
        protected PostRepositoryInterface $repository
    ) {
    }

    public function index(): View
    {
        $userId = Auth::id();
        $page   = request()->query('page', 1);
        $order  = request()->query('order', 0) ? 'asc' : 'desc';

        $posts = $this->repository->indexByUser($userId, $page, $order);

        return view('dashboard.post.index', compact('posts'));
    }

    public function create(): View
    {
        return view('dashboard.post.create');
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $data = $request->validated() + ['user_id' => Auth::id()];

        $this->repository->store($data);

        return redirect()->route('dashboard.post.index');
    }

    /**
     * @throws PostNotFoundException
     */
    public function show(int $id): View
    {
        $post = $this->repository->getByUser($id, Auth::id());

        if ($post === null) {
            throw new PostNotFoundException();
        }

        return view('front.post.show', compact('post'));
    }
}
