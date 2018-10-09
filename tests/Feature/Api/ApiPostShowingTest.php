<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Blog\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiPostShowingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function apiShowsSinglePost()
    {
        $post = factory(Post::class)->create();
        $response = $this->json('get', route('api.posts.show', $post));

        $response->assertSee($post->title);
        $response->assertSee($post->preview);
        $response->assertJsonFragment(['body' => $post->body]);
    }
}
