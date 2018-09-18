<?php

namespace Tests\Unit;

use App\Post;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function hasManyPosts()
    {
        $user = factory(User::class)->create();

        $posts = factory(Post::class, 2)->create([
            'user_id' => $user->id
        ]);

        $user->load('posts');

        $this->assertInstanceOf('Illuminate\Support\Collection', $user->posts);
        $this->assertEquals(2, $user->posts->count());
        $this->assertInstanceOf('App\Post', $user->posts->first());
    }
}
