<?php

namespace Blog\Http\Controllers;

use Blog\Models\Tag;
use App\Http\Controllers\Controller;
use Blog\Repositories\TagsRepository;

class TagsController extends Controller
{
    public function __invoke(Tag $tag, TagsRepository $tagsRepo)
    {
        $posts = $tagsRepo->getAllPostsForTag($tag);

        return view('tags.show', compact('tag', 'posts'));
    }
}
