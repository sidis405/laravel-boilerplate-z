<?php

namespace Tests\Unit;

use Tests\TestCase;
use Blog\Models\Post;
use Blog\Models\User;
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
        $this->assertInstanceOf(Post::class, $user->posts->first());
    }

    /** @test */
    public function userKnowsIfIsAdmin()
    {
        $admin = factory(User::class)->create(['role' => 'admin']);
        $user = factory(User::class)->create();

        $this->assertTrue($admin->isAdmin());
        $this->assertFalse($user->isAdmin());
    }

    /** @test */
    public function userKnowsIfAuthored()
    {
        $author = factory(User::class)->create();
        $notAuthor = factory(User::class)->create();

        $post = factory(Post::class)->create([
            'user_id' => $author->id
        ]);

        $this->assertTrue($author->isAuthorOf($post));
        $this->assertFalse($notAuthor->isAuthorOf($post));
    }
}
