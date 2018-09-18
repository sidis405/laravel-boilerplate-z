<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Post;
use App\Category;
use App\Http\Requests\PostRequest;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('show');
    }

    public function show(Post $post)
    {
        $post->load('category', 'user');

        return view('posts.show', compact('post'));
    }

    public function create()
    {
        $categories = Category::get();
        $tags = Tag::get();

        return view('posts.create', compact('categories', 'tags'));
    }

    public function store(PostRequest $request)
    {
        $post = $request->user()->posts()->create($request->validated());

        $post->tags()->sync($request->tags);

        return redirect()->route('posts.show', $post);
    }
}
