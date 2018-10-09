<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Blog\Models\Tag;
use Blog\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiPostIndexingByTagTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function postsAreShownByTagInRecentOrder()
    {
        // arrange
        $goodTag = factory(Tag::class)->create();
        $badTag = factory(Tag::class)->create();

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

        foreach ($posts as $post) {
            $post->tags()->sync([$goodTag->id]);
        }

        $shouldNotSeeThis = factory(Post::class)->create();
        $shouldNotSeeThis->tags()->sync([$badTag->id]);

        // act
        $response = $this->json('get', route('api.tags.show', $goodTag));

        // assert
        $response->assertSeeInOrder($posts->sortByDesc('created_at')->pluck('title')->toArray());

        $response->assertDontSee($shouldNotSeeThis->title);
    }
}
