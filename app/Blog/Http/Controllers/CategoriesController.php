<?php

namespace Blog\Http\Controllers;

use Blog\Models\Category;
use App\Http\Controllers\Controller;
use Blog\Repositories\CategoriesRepository;

class CategoriesController extends Controller
{
    public function __invoke(Category $category, CategoriesRepository $categoriesRepo)
    {
        $posts = $categoriesRepo->getAllPostForCategory($category);

        return view('categories.show', compact('posts', 'category'));
    }
}
