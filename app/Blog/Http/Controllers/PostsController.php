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
        $this->middleware('auth')->except('index', 'show');
        $this->middleware('can:update,post')->only('edit', 'update');
    }

    public function index()
    {
        $posts = Post::with('user', 'category', 'tags')->latest()->get();

        return view('posts.index', compact('posts'));
    }

    public function show(Post $post)
    {
        $post->load('category', 'user', 'tags');

        return view('posts.show', compact('post'));
    }

    public function create()
    {
        $categories = Category::get();
        $tags = Tag::get();

        return view('posts.create', compact('categories', 'tags'))->withPost(new Post);
    }

    public function store(PostRequest $request)
    {
        $post = $request->user()->posts()->create($request->validated());

        $post->tags()->sync($request->tags);

        return redirect()->route('posts.show', $post);
    }

    public function edit(Post $post)
    {
        $categories = Category::get();
        $tags = Tag::get();

        $post->load('tags');

        return view('posts.edit', compact('post', 'categories', 'tags'));
    }

    public function update(Post $post, PostRequest $request)
    {
        $post->update($request->validated());

        $post->tags()->sync($request->tags);

        return redirect()->route('posts.show', $post);
    }
}
