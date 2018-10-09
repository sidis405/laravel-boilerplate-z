<?php

namespace Tests\Feature;

use Tests\TestCase;
use Blog\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostDeletionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function aUserCannotDeleteOthersPost()
    {
        $this->signIn()->withExceptionHandling();

        $post = factory(Post::class)->create();

        $response = $this->delete(route('posts.destroy', $post), []);

        $response->assertStatus(403); //policy
    }

    /** @test */
    public function adminCanDeleteAnyPost()
    {
        [$post, $postData, $tags] = $this->updatePostAs('admin');

        $response = $this->delete(route('posts.destroy', $post), $postData);

        $this->assertDatabaseMissing('posts', collect($postData)->except('tags')->toArray());
    }
}
