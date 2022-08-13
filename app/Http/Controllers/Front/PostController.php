<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::query()
                     ->with('user')
                     ->where('publication_date', '<=', now())
                     ->orderBy('publication_date', request()->query('order', 0) ? 'asc' : 'desc')
                     ->paginate()
                     ->withQueryString();

        return view('front.post.index', compact('posts'));
    }

    public function show($id)
    {
        $post = Post::query()
                    ->where('publication_date', '<=', now())
                    ->findOrFail($id);

        return view('front.post.show', compact('post'));
    }
}
