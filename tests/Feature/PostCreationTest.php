<?php

namespace Tests\Feature;

use Tests\TestCase;
use Blog\Models\Tag;
use Blog\Models\Post;
use Blog\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostCreationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function aGuestUserCannotSeePostCreationForm()
    {
        $this->withExceptionHandling();

        $response = $this->get(route('posts.create'));
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function aUserCanSeePostCreationForm()
    {
        // arrange
        $this->signIn();

        $categories = factory(Category::class, 10)->create();
        $tags = factory(Tag::class, 10)->create();

        // act
        $response = $this->get(route('posts.create'));

        $response->assertStatus(200);

        // Text Assertion
        $response->assertSee('Article title');
        $response->assertSee('Insert synopsis');
        $response->assertSee('Article body');
        $response->assertSee('Pick a category');
        $response->assertSee('Tag this article');
        $response->assertSee('Publish');

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
    public function aGuestUserCannotCreatePost()
    {
        $this->withExceptionHandling();

        $response = $this->post(route('posts.store'), []);

        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function aUserCanCreatePost()
    {
        $this->signIn();

        $category = factory(Category::class)->create();
        $tags = factory(Tag::class, 3)->create();
        $postData = [
            'title' => 'A test post',
            'preview' => 'Some preview text',
            'body' => 'Article body',
            'category_id' => $category->id,
            'tags' => $tags->pluck('id'),
        ];

        $response = $this->post(route('posts.store'), $postData);

        // assert

        $post = Post::first();

        $this->assertDatabaseHas('posts', collect($postData)->except('tags')->toArray());
        $this->assertEquals($post->load('tags')->tags->pluck('id'), $tags->pluck('id'));
        $response->assertStatus(302);
        $response->assertRedirect(route('posts.show', $post));
    }

    /** @test */
    public function hasMandatoryFields()
    {
        $this->signIn()->withExceptionHandling();

        $response = $this->post(route('posts.store'), []);

        $response->assertSessionHasErrors([
            'title', 'preview', 'body', 'category_id'
        ]);
    }
}
