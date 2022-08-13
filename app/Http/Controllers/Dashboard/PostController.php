<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StoreRequest;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::query()
                     ->where('user_id', Auth::id())
                     ->orderBy('publication_date', request()->query('order', 0) ? 'asc' : 'desc')
                     ->paginate()
                     ->withQueryString();

        return view('dashboard.post.index', compact('posts'));
    }

    public function create()
    {
        return view('dashboard.post.create');
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated() + ['user_id' => Auth::id()];

        Post::query()
            ->create($data);

        return redirect()->route('dashboard.post.index');
    }

    public function show($id)
    {
        $post = Post::query()
                    ->where('user_id', Auth::id())
                    ->findOrFail($id);

        return view('front.post.show', compact('post'));
    }
}
