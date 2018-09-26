<?php

namespace Blog\Repositories;

use Blog\Models\Post;
use Blog\Models\Category;

class CategoriesRepository
{
    public function getAllPostForCategory(Category $category)
    {
        return Post::where('category_id', $category->id)->with('user', 'category', 'tags')->latest()->get();
    }
}
