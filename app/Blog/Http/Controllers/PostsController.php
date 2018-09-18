<?php

namespace Blog\Http\Controllers;

use Blog\Models\Tag;
use Blog\Models\Post;
use Blog\Models\Category;
use Blog\Http\Requests\PostRequest;
use App\Http\Controllers\Controller;

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
