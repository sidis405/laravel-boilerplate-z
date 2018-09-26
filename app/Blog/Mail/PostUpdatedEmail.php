<?php

namespace Blog\Mail;

use Blog\Models\Post;
use Blog\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PostUpdatedEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $recipient;
    public $sender;
    public $post;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $recipient, User $sender, Post $post)
    {
        $this->recipient = $recipient;
        $this->sender = $sender;
        $this->post = $post;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Il post '" . $this->post->title . "' è stato modificato")->markdown('emails.posts.updated-email');
    }
}
