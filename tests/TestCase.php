<?php

namespace Tests;

use Blog\Models\Tag;
use Blog\Models\Post;
use Blog\Models\User;
use Blog\Models\Category;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp()
    {
        parent::setUp();

        $this->withoutExceptionHandling();

        return $this;
    }

    public function signIn(User $user = null)
    {
        $user = $user ?? factory(User::class)->create();

        $this->be($user);

        return $this;
    }

    public function updatePostAs($role)
    {
        if ($role == 'admin') {
            $user = factory(User::class)->create([
                'role' => 'admin'
            ]);

            $post = factory(Post::class)->create();
        } elseif ($role == 'user') {
            $user = factory(User::class)->create();

            $post = factory(Post::class)->create([
                'user_id' => $user->id
            ]);
        } elseif ($role == 'admin-user') {
            $user = factory(User::class)->create([
                'role' => 'admin'
            ]);

            $post = factory(Post::class)->create([
                'user_id' => $user->id
            ]);
        }

        $this->signIn($user);

        $category = factory(Category::class)->create();
        $tags = factory(Tag::class, 3)->create();
        $postData = [
            'title' => 'A test post',
            'preview' => 'Some preview text',
            'body' => 'Article body',
            'category_id' => $category->id,
            'tags' => $tags->pluck('id'),
        ];

        return [$post, $postData, $tags];
    }
}
