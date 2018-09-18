<?php

namespace Tests\Feature;

use Tests\TestCase;
use Blog\Models\Tag;
use Blog\Models\Post;
use Blog\Models\User;
use Blog\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostShowingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function aPostCanBeShown()
    {
        $post = factory(Post::class)->create();
        $response = $this->get(route('posts.show', $post));
        $response->assertSee($post->title);
        $response->assertSee($post->preview);
        $response->assertSee($post->body);
    }

    /** @test */
    public function aPostShowsTheCategoryItBelongsTo()
    {
        // arrange
        $category = factory(Category::class)->create();
        $post = factory(Post::class)->create([
            'category_id' => $category->id
        ]);

        // act
        $response = $this->get(route('posts.show', $post));

        // assert
        $response->assertSee($category->name);
    }

    /** @test */
    public function aPostShowsTheAuthorItBelongsTo()
    {
        // arrange
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create([
            'user_id' => $user->id
        ]);

        // act
        $response = $this->get(route('posts.show', $post));

        // assert
        $response->assertSee($user->name);
    }

    /** @test */
    public function aPostShowsOwnTags()
    {
        // arrange
        $tags = factory(Tag::class, 3)->create();
        $post = factory(Post::class)->create();
        $post->tags()->sync($tags->pluck('id'));

        // act
        $response = $this->get(route('posts.show', $post));

        // assert
        foreach ($tags as $tag) {
            $response->assertSee($tag->name);
        }
    }
}
