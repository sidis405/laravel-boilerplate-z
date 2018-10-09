<?php

namespace Blog\Repositories;

use Blog\Models\Post;
use Blog\Models\Category;

class CategoriesRepository
{
    public function getAllPostForCategory(Category $category)
    {
        return Post::filterCategory($category)->latest()->get();
    }
}
