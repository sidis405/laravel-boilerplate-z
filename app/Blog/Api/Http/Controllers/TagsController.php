<?php

namespace Blog\Api\Http\Controllers;

use Blog\Models\Tag;
use App\Http\Controllers\Controller;
use Blog\Repositories\TagsRepository;

class TagsController extends Controller
{
    /**
     * @SWG\Get(path="/tags/{tag}",
     *  tags={"Tags"},
     *  summary="Show Tag",
     *  description="Show posts belonging to a given tag",
     *  operationId="showTag",
     *  produces={"application/json"},
     *  @SWG\Parameter(
     *   name="tag",
     *   in="path",
     *   description="Tag identifier (example: id)",
     *   required=true,
     *   type="string"
     * ),
     *  @SWG\Response(response="200", description="Success"),
     *  @SWG\Response(response="500", description="Internal Server Error")
     * )
     */
    public function __invoke(Tag $tag, TagsRepository $tagsRepo)
    {
        return response()->json([
            'response' => 'success',
            'result' => [
                'tag' => $tag,
                'posts' => $tagsRepo->getAllPostsForTag($tag)
            ]
        ]);
    }
}
