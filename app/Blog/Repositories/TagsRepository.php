<?php

namespace Blog\Repositories;

use Blog\Models\Tag;
use Blog\Models\Post;

class TagsRepository
{
    public function getAllPostsForTag(Tag $tag)
    {
        return Post::filterTag($tag)->latest()->get();
    }
}
