<?php

namespace App\Http\Controllers\Dashboard;

use App\Contracts\PostRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StoreRequest;
use Illuminate\Support\Facades\Auth;

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
        $posts = $this->repository->indexByAuthUser();

        return view('dashboard.post.index', compact('posts'));
    }

    public function create()
    {
        return view('dashboard.post.create');
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated() + ['user_id' => Auth::id()];

        $this->repository->store($data);

        return redirect()->route('dashboard.post.index');
    }

    public function show(int $id)
    {
        $post = $this->repository->getByAuthUser($id);

        return view('front.post.show', compact('post'));
    }
}
