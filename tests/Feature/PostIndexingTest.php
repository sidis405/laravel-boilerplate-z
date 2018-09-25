<?php

namespace Tests\Feature;

use Tests\TestCase;
use Blog\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostIndexingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function homeShowsAllPostLatestFirst()
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

        $response = $this->get(route('posts.index'));

        $response->assertSeeInOrder($posts->sortByDesc('created_at')->pluck('title')->toArray());
    }
}
