<?php

namespace Blog\Repositories;

use Blog\Models\Post;
use Illuminate\Http\Request;

class PostsRepository
{
    /**
     * Get all posts latest first
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        return Post::latest()->get();
    }

    /**
     * Get single post
     *
     * @param \Blog\Models\Post $post
     * @return \Blog\Models\Post $post
     */
    public function show(Post $post)
    {
        return $post;
    }

    /**
     * Save post to database
     *
     * @param \Illuminate\Http\Request $request
     * @return \Blog\Models\Post $post
     */
    public function store(Request $request)
    {
        return $request->user()->createAndSyncFrom($request);
    }

    /**
     * Update post in database
     *
     * @param \Illuminate\Http\Request $request
     * @param \Blog\Models\Post $post Post to be updated
     * @return \Blog\Models\Post $post Updated post
     */
    public function update(Post $post, Request $request)
    {
        return $request->user()->updateAndSyncFrom($post, $request);
    }

    /**
     * Delete post from database
     *
     * @param \Blog\Models\Post $post Post to be deleted
     * @return \Blog\Models\Post $post Updated post
     */
    public function destroy(Post $post)
    {
        $post->tags()->sync([]);
        $post->delete();

        return $post;
    }
}
