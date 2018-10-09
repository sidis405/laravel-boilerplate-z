<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Blog\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiPostIndexingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function postsIndexShowsAllPostLatestFirst()
    {
        $posts = collect([
            factory(Post::class)->create([
                'created_at' => now()->subHours(3)
            ]),
            factory(Post::class)->create([
                'created_at' => now()->subHours(2)
            ]),
            factory(Post::class)->create([
                'created_at' => now()->subHours(1)
            ]),
        ]);

        $response = $this->json('get', route('api.posts.index'));

        $response->assertSeeInOrder($posts->sortByDesc('created_at')->pluck('title')->toArray());
    }
}
