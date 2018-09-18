<?php

namespace Tests\Unit;

use Tests\TestCase;
use Blog\Models\Tag;
use Blog\Models\Post;
use Blog\Models\User;
use Blog\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function itBelongsToACategory()
    {
        // arrange
        $category = factory(Category::class)->create();
        $post = factory(Post::class)->create([
            'category_id' => $category->id
        ]);

        // act
        $post->load('category');

        // assert
        $this->assertInstanceOf(Category::class, $post->category);
    }

    /** @test */
    public function itBelongsToAUser()
    {
        // arrange
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create([
            'user_id' => $user->id
        ]);

        // act
        $post->load('user');

        // assert
        $this->assertInstanceOf(User::class, $post->user);
    }

    /** @test */
    public function itBelongsToManyTags()
    {
        $num_tags = 3;
        // arrange
        $tags = factory(Tag::class, $num_tags)->create();
        $post = factory(Post::class)->create();
        $post->tags()->sync($tags->pluck('id'));

        // act
        $post->load('tags');

        // assert
        // un post appartiene a piu tags // Collection
        $this->assertInstanceOf('Illuminate\Support\Collection', $post->tags);
        // un post appartiene al num_tags associati con lui
        $this->assertEquals($num_tags, $post->tags->count());
        // un tag del post è di tipo App\Tag
        $this->assertInstanceOf(Tag::class, $post->tags->first());
    }
}
