<?php

namespace Blog\Http\Controllers;

use Blog\Models\Post;
use Illuminate\Http\Request;
use Blog\Http\Requests\PostRequest;
use App\Http\Controllers\Controller;
use Blog\Repositories\PostsRepository;

class PostsController extends Controller
{

    /**
     * Post Repo containing logic
     *
     * @var \Blog\Repositories\PostsRepository
     */
    protected $postsRepo;

    /**
     * Class constructor
     *
     * @param \Blog\Repositories\PostsRepository $postsRepo
     * @return void
     */
    public function __construct(PostsRepository $postsRepo)
    {
        $this->middleware('auth')->except('index', 'show');
        $this->middleware('can:update,post')->only('edit', 'update');
        $this->middleware('can:delete,post')->only('destroy');

        $this->postsRepo = $postsRepo;
    }


    /**
     * Show post index ordered by latest
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = $this->postsRepo->index();

        return view('posts.index', compact('posts'));
    }

    /**
     * Show a single post
     *
     * @param \Blog\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $post = $this->postsRepo->show($post);

        return view('posts.show', compact('post'));
    }

    /**
     * Show post creation form
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create')->withPost(new Post);
    }

    /**
     * Store a post in the database
     *
     * @param \Blog\Http\Requests\PostRequest $request Self validating form request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $post = $this->postsRepo->store($request);

        return redirect()->route('posts.show', $post);
    }

    /**
     * Show edit form for post
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    /**
     * Update a single post
     *
     * @param \Blog\Models\Post $post The post identifier to update
     * @param \Blog\Http\Requests\PostRequest $request Self validating form request
     * @return \Illuminate\Http\Response
     */
    public function update(Post $post, PostRequest $request)
    {
        $post = $this->postsRepo->update($post, $request);

        return redirect()->route('posts.show', $post);
    }

    /**
     * Delete a post from the database
     *
     * @param \Blog\Models\Post $post The post identifier to delete
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $this->postsRepo->destroy($post);

        return redirect()->route('posts.index');
    }
}
