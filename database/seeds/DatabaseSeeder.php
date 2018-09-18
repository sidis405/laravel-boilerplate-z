<?php

use Blog\Models\Tag;
use Blog\Models\Post;
use Blog\Models\User;
use Blog\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $users = factory(User::class, 2)->create();
        $categories = factory(Category::class, 10)->create();
        $tags = factory(Tag::class, 20)->create();

        foreach ($users as $user) {
            $posts = factory(Post::class, 2)->create([
                'user_id' => $user->id,
                'category_id' => $categories->random()->id,
            ]);

            foreach ($posts as $post) {
                $post->tags()->sync(
                    $tags->random(3)->pluck('id')
                );
            }
        }
    }
}
