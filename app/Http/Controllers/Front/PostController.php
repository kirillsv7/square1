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
                     ->orderBy('publication_date', 'desc')
                     ->paginate();

        return view('index', compact('posts'));
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);

        return view('post', compact('post'));
    }
}
