<?php

namespace Blog\Http\Controllers;

use Blog\Models\Post;
use Blog\Http\Requests\PostRequest;
use App\Http\Controllers\Controller;
use Blog\Repositories\PostsRepository;

class PostsController extends Controller
{
    protected $postsRepo;

    public function __construct(PostsRepository $postsRepo)
    {
        $this->middleware('auth')->except('index', 'show');
        $this->middleware('can:update,post')->only('edit', 'update');
        $this->middleware('can:delete,post')->only('destroy');

        $this->postsRepo = $postsRepo;
    }

    public function index()
    {
        $posts = $this->postsRepo->index();

        return view('posts.index', compact('posts'));
    }

    public function show(Post $post)
    {
        $post = $this->postsRepo->show($post);

        return view('posts.show', compact('post'));
    }

    public function create()
    {
        return view('posts.create')->withPost(new Post);
    }

    public function store(PostRequest $request)
    {
        $post = $this->postsRepo->store($request);

        return redirect()->route('posts.show', $post);
    }

    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    public function update(Post $post, PostRequest $request)
    {
        $post = $this->postsRepo->update($post, $request);

        return redirect()->route('posts.show', $post);
    }

    public function destroy(Post $post)
    {
        $this->postsRepo->destroy($post);

        return redirect()->route('posts.index');
    }
}
