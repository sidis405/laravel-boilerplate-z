<?php

namespace Tests\Feature;

use Tests\TestCase;
use Blog\Models\User;
use Blog\Mail\PostUpdatedEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostEditingMailTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function adminGetsEmailIfPostEditedByAuthor()
    {
        Mail::fake();

        $admin = factory(User::class)->create(['role' => 'admin']);

        [$post, $postData, $tags] = $this->updatePostAs('user');

        $author = auth()->user();

        $response = $this->patch(route('posts.update', $post), $postData);

        Mail::assertSent(PostUpdatedEmail::class, function ($mail) use ($admin, $author, $post) {
            $mail->build();
            return $mail->hasTo($admin->email) && ($mail->subject == "Il post '" . $post->fresh()->title . "' è stato modificato") &&
                ($mail->post->id == $post->id) &&
                ($mail->recipient->id == $admin->id) &&
                ($mail->sender->id == $author->id);
        });
    }

    /** @test */
    public function authorGetsEmailIFPostEditedByAdmin()
    {
        Mail::fake();


        [$post, $postData, $tags] = $this->updatePostAs('admin');

        $author = $post->load('user')->user;

        $admin = auth()->user();



        $response = $this->patch(route('posts.update', $post), $postData);

        Mail::assertSent(PostUpdatedEmail::class, function ($mail) use ($admin, $author, $post) {
            $mail->build();
            return $mail->hasTo($author->email) && ($mail->subject == "Il post '" . $post->fresh()->title . "' è stato modificato") &&
                ($mail->post->id == $post->id) &&
                ($mail->recipient->id == $author->id) &&
                ($mail->sender->id == $admin->id);
        });
    }

    /** @test */
    public function adminDoesNotGetEmailIFEditedOwnPost()
    {
        Mail::fake();

        [$post, $postData, $tags] = $this->updatePostAs('admin-user');

        $response = $this->patch(route('posts.update', $post), $postData);

        Mail::assertNotSent(PostUpdatedEmail::class);
    }
}
