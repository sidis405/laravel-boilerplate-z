<?php

namespace Tests\Feature;

use Tests\TestCase;
use Blog\Models\Post;
use Blog\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostIndexingByCategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function homeShowsAllPostLatestFirst()
    {
        $category = factory(Category::class)->create();

        $posts = collect([
            factory(Post::class)->create([
                'created_at' => now()->subHours(3),
                'category_id' => $category->id
            ]),
            factory(Post::class)->create([
                'created_at' => now()->subHours(2),
                'category_id' => $category->id
            ]),
            factory(Post::class)->create([
                'created_at' => now()->subHours(1),
                'category_id' => $category->id
            ]),
        ]);

        $shouldNotSeeThis = factory(Post::class)->create();

        $response = $this->get(route('categories.show', $category));

        $response->assertSeeInOrder($posts->sortByDesc('created_at')->pluck('title')->toArray());

        $response->assertDontSee($shouldNotSeeThis->title);
    }
}
