<?php

namespace Blog\Api\Http\Controllers;

use Blog\Models\Post;
use Blog\Http\Requests\PostRequest;
use App\Http\Controllers\Controller;
use Blog\Repositories\PostsRepository;

class PostsController extends Controller
{
    protected $postsRepo;

    public function __construct(PostsRepository $postsRepo)
    {
        $this->middleware('jwt.auth')->except('index', 'show');
        $this->middleware('can:update,post')->only('edit', 'update');
        $this->middleware('can:delete,post')->only('destroy');

        $this->postsRepo = $postsRepo;
    }

    /**
     * @SWG\Get(path="/posts",
     *  tags={"Posts"},
     *  summary="Posts Index",
     *  description="Index of posts ordered by latest",
     *  operationId="indexPost",
     *  produces={"application/json"},
     *  @SWG\Response(response="200", description="Success"),
     *  @SWG\Response(response="500", description="Internal Server Error")
     * )
     */
    public function index()
    {
        return response()->json([
            'response' => 'success',
            'result' => [
                'posts' => $this->postsRepo->index()
            ]
        ]);
    }


    /**
     * @SWG\Get(path="/posts/{post}",
     *  tags={"Posts"},
     *  summary="Posts Show",
     *  description="Show a single post",
     *  operationId="showPost",
     *  produces={"application/json"},
     *  @SWG\Parameter(
     *   name="post",
     *   in="path",
     *   description="Post identifier (example: id)",
     *   required=true,
     *   type="string"
     * ),
     *  @SWG\Response(response="200", description="Success"),
     *  @SWG\Response(response="500", description="Internal Server Error")
     * )
     */
    public function show(Post $post)
    {
        return response()->json([
            'response' => 'success',
            'result' => [
                'post' =>  $this->postsRepo->show($post)
            ]
        ]);
    }


    /**
     * @SWG\Post(path="/posts",
     *  tags={"Posts"},
     *  summary="Posts Store",
     *  description="Store a post in the database",
     *  operationId="storePost",
     *  produces={"application/json"},
     *  security={{"default": {}}},
     *  @SWG\Parameter(
     *   name="title",
     *   in="formData",
     *   description="The title",
     *   required=true,
     *   type="string"
     * ),
     *  @SWG\Parameter(
     *   name="preview",
     *   in="formData",
     *   description="Short introduction of the post",
     *   required=true,
     *   type="string"
     * ),
     *  @SWG\Parameter(
     *   name="body",
     *   in="formData",
     *   description="text of the article",
     *   required=true,
     *   type="string"
     * ),
     *  @SWG\Parameter(
     *   name="category_id",
     *   in="formData",
     *   description="Id of category to tag post with",
     *   required=true,
     *   type="integer"
     * ),
     *  @SWG\Parameter(
     *   name="cover",
     *   in="formData",
     *   description="Post cover Image",
     *   required=false,
     *   type="file"
     * ),
     *  @SWG\Response(response="201", description="Resource created"),
     *  @SWG\Response(response="401", description="Unauthorized"),
     *  @SWG\Response(response="422", description="Validation failed"),
     *  @SWG\Response(response="500", description="Internal Server Error")
     * )
     */
    public function store(PostRequest $request)
    {
        return response()->json([
            'response' => 'success',
            'result' => [
                'post' =>  $this->postsRepo->store($request)
            ]
        ], 201);
    }

    /**
     * @SWG\Patch(path="/posts/{post}",
     *  tags={"Posts"},
     *  summary="Posts Update",
     *  description="Update a post in the database",
     *  operationId="updatePost",
     *  produces={"application/json"},
     *  security={{"default": {}}},
     *  @SWG\Parameter(
     *   name="post",
     *   in="path",
     *   description="Id of post to update",
     *   required=true,
     *   type="string"
     * ),
     *  @SWG\Parameter(
     *   name="title",
     *   in="formData",
     *   description="The title",
     *   required=true,
     *   type="string"
     * ),
     *  @SWG\Parameter(
     *   name="preview",
     *   in="formData",
     *   description="Short introduction of the post",
     *   required=true,
     *   type="string"
     * ),
     *  @SWG\Parameter(
     *   name="body",
     *   in="formData",
     *   description="text of the article",
     *   required=true,
     *   type="string"
     * ),
     *  @SWG\Parameter(
     *   name="category_id",
     *   in="formData",
     *   description="Id of category to tag post with",
     *   required=true,
     *   type="integer"
     * ),
     *  @SWG\Parameter(
     *   name="cover",
     *   in="formData",
     *   description="Post cover Image",
     *   required=false,
     *   type="file"
     * ),
     *  @SWG\Response(response="201", description="Resource created"),
     *  @SWG\Response(response="401", description="Unauthorized"),
     *  @SWG\Response(response="422", description="Validation failed"),
     *  @SWG\Response(response="500", description="Internal Server Error")
     * )
     */
    public function update(Post $post, PostRequest $request)
    {
        return response()->json([
            'response' => 'success',
            'result' => [
                'post' =>  $post = $this->postsRepo->update($post, $request)
            ]
        ]);
    }

    /**
     * @SWG\Delete(path="/posts/{post}",
     *  tags={"Posts"},
     *  summary="Posts Delete",
     *  description="Delete a single post",
     *  operationId="DeletePost",
     *  produces={"application/json"},
     *  @SWG\Parameter(
     *   name="post",
     *   in="path",
     *   description="Post identifier (example: id)",
     *   required=true,
     *   type="string"
     * ),
     *  @SWG\Response(response="200", description="Success"),
     *  @SWG\Response(response="500", description="Internal Server Error")
     * )
     */
    public function destroy(Post $post)
    {
        return response()->json([
            'response' => 'success',
            'result' => [
                'post' =>  $post = $this->postsRepo->destroy($post)
            ]
        ]);
    }
}
