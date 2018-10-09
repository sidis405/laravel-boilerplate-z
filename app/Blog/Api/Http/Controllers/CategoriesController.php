<?php

namespace Blog\Api\Http\Controllers;

use Blog\Models\Category;
use App\Http\Controllers\Controller;
use Blog\Repositories\CategoriesRepository;

class CategoriesController extends Controller
{
    /**
     * @SWG\Get(path="/categories/{category}",
     *  tags={"Categories"},
     *  summary="Show Category",
     *  description="Show posts belonging to a given category",
     *  operationId="showCategory",
     *  produces={"application/json"},
     *  @SWG\Parameter(
     *   name="category",
     *   in="path",
     *   description="Category identifier (example: id)",
     *   required=true,
     *   type="string"
     * ),
     *  @SWG\Response(response="200", description="Success"),
     *  @SWG\Response(response="500", description="Internal Server Error")
     * )
     */
    public function __invoke(Category $category, CategoriesRepository $categoriesRepo)
    {
        return response()->json([
            'response' => 'success',
            'result' => [
                'category' => $category,
                'posts' => $categoriesRepo->getAllPostForCategory($category)
            ]
        ]);
    }
}
