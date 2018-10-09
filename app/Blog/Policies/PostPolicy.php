<?php

namespace Blog\Policies;

use Blog\Models\Post;
use Blog\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the post.
     *
     * @param  \Blog\Models\User  $user
     * @param  \Blog\Models\Post  $post
     * @return mixed
     */
    public function update(User $user, Post $post)
    {
        return $user->isAuthorOf($post) || $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the post.
     *
     * @param  \Blog\Models\User  $user
     * @param  \Blog\Models\Post  $post
     * @return mixed
     */
    public function delete(User $user, Post $post)
    {
        return $user->isAuthorOf($post) || $user->isAdmin();
    }
}
