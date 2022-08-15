<?php

namespace App\Http\Controllers\Dashboard;

use App\Contracts\PostRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StoreRequest;
use App\Models\Post;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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

    public function show(int $id): View
    {
        if (!$post = $this->repository->getByUser($id, Auth::id())) {
            throw (new ModelNotFoundException)->setModel(Post::class, [$id]);
        }

        return view('front.post.show', compact('post'));
    }
}
