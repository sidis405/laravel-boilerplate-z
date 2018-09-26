<?php

namespace Tests\Feature;

use Tests\TestCase;
use Blog\Models\Tag;
use Blog\Models\Post;
use Blog\Models\User;
use Blog\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostEditingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function aGuestUserCannotSeeEditingForm()
    {
        $this->withExceptionHandling();
        $post = factory(Post::class)->create();

        $response = $this->get(route('posts.edit', $post));

        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function aUserCanSeeOwnPostEditingForm()
    {
        // arrange
        $this->signIn();

        $post = factory(Post::class)->create([
            'user_id' => auth()->id()
        ]);

        $categories = factory(Category::class, 10)->create();
        $tags = factory(Tag::class, 10)->create();

        // act
        $response = $this->get(route('posts.edit', $post));

        $response->assertStatus(200);

        // Text Assertion
        $response->assertSee('Article title');
        $response->assertSee($post->title);
        $response->assertSee('Choose a cover');
        $response->assertSee('Insert synopsis');
        $response->assertSee($post->preview);
        $response->assertSee('Article body');
        $response->assertSee($post->body);
        $response->assertSee('Pick a category');
        $response->assertSee('Tag this article');
        $response->assertSee('Update');

        $response->assertViewHas('categories');
        $response->assertViewHas('tags');

        foreach ($categories as $category) {
            $response->assertSee($category->name);
        }

        foreach ($tags as $tag) {
            $response->assertSee($tag->name);
        }
    }

    /** @test */
    public function userCanUpdateOwnPost()
    {
        factory(User::class)->create(['role' => 'admin']);

        [$post, $postData, $tags] = $this->updatePostAs('user');

        $response = $this->patch(route('posts.update', $post), $postData);

        // assert

        $post = Post::first();

        $this->assertDatabaseHas('posts', collect($postData)->except('tags')->toArray());
        $this->assertEquals($post->load('tags')->tags->pluck('id'), $tags->pluck('id'));
        $response->assertStatus(302);
        $response->assertRedirect(route('posts.show', $post));
    }

    /** @test */
    public function aUserCannotModifyOthersPost()
    {
        $this->signIn()->withExceptionHandling();

        $post = factory(Post::class)->create();

        $response = $this->patch(route('posts.update', $post), []);

        $response->assertStatus(403); //policy
    }

    /** @test */
    public function adminCanModifyAnyPost()
    {
        [$post, $postData, $tags] = $this->updatePostAs('admin');

        $response = $this->patch(route('posts.update', $post), $postData);

        $this->assertDatabaseHas('posts', collect($postData)->except('tags')->toArray());
    }
}
