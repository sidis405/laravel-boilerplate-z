<?php

namespace App\Http\Controllers;

use App\Post;

class PostsController extends Controller
{
    public function show(Post $post)
    {
        $post->load('category', 'user');

        return view('posts.show', compact('post'));
    }
}
