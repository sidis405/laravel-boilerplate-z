<?php

namespace Blog\Repositories;

use Blog\Models\Post;
use Illuminate\Http\Request;

class PostsRepository
{
    public function index()
    {
        return Post::latest()->get();
    }

    public function show(Post $post)
    {
        return $post;
    }

    public function store(Request $request)
    {
        return $request->user()->createAndSyncFrom($request);
    }

    public function update(Post $post, Request $request)
    {
        return $request->user()->updateAndSyncFrom($post, $request);
    }

    public function destroy(Post $post)
    {
        $post->tags()->sync([]);
        $post->delete();

        return $post;
    }
}
