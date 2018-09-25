<?php

namespace Tests\Feature;

use Tests\TestCase;
use Blog\Models\Tag;
use Blog\Models\Post;
use Blog\Models\Category;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostImageUploadTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function userCanUploadAnImage()
    {
        $this->signIn();

        Storage::fake();

        $category = factory(Category::class)->create();
        $tags = factory(Tag::class, 3)->create();

        $cover =  UploadedFile::fake()->image('foo.jpg');

        $postData = [
            'title' => 'A test post',
            'preview' => 'Some preview text',
            'body' => 'Article body',
            'category_id' => $category->id,
            'tags' => $tags->pluck('id'),
            'cover' => $cover
        ];

        $response = $this->post(route('posts.store'), $postData);

        $post = Post::first();

        $this->assertDatabaseHas('posts', collect($postData)->except('tags', 'cover')->toArray());

        Storage::disk('public')->assertExists('covers/' . md5($cover->getClientOriginalName()) . '.' . $cover->getClientOriginalExtension());
    }

    /** @test */
    public function creationFormHasCoverElement()
    {
        $this->signIn();

        $response = $this->get(route('posts.create'));

        $response->assertSee('Choose a cover');
    }

    /** @test */
    public function coversAreShown()
    {
        $post = factory(Post::class)->create();

        $response = $this->get(route('posts.show', $post));

        $response->assertSee($post->cover);
    }
}
