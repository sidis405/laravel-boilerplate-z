<?php

namespace Blog\Jobs;

use Blog\Models\Post;
use Blog\Models\User;
use Illuminate\Bus\Queueable;
use Blog\Mail\PostUpdatedEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendPostUpdateEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $post;
    protected $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Post $post, User $user)
    {
        $this->post = $post;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $author = $this->post->load('user')->user;
        $admin = User::where('role', 'admin')->first();

        if ($this->user->isAdmin() && ! $this->user->isAuthorOf($this->post)) {
            Mail::to($author)->send(new PostUpdatedEmail($author, $admin, $this->post));
        } elseif (! $this->user->isAdmin() && $this->user->isAuthorOf($this->post)) {
            Mail::to($admin)->send(new PostUpdatedEmail($admin, $author, $this->post));
        }
    }
}
