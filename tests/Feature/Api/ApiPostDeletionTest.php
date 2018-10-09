<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Blog\Models\Post;
use Tests\AttachJwtToken;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiPostDeletionTest extends TestCase
{
    use RefreshDatabase;
    use AttachJwtToken;

    /** @test */
    public function aUserCannotDeleteOthersPostWithApi()
    {
        $this->signIn()->withExceptionHandling();

        $post = factory(Post::class)->create();

        $response = $this->json('delete', route('api.posts.destroy', $post), []);

        $response->assertStatus(403); //policy
    }
}
