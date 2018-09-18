<?php

use Blog\Models\Post;
use Blog\Models\User;
use Blog\Models\Category;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'title' => ucfirst($faker->sentence),
        'preview' => $faker->sentences(3, true),
        'body' => $faker->paragraphs(5, true),
        'category_id' => factory(Category::class),
        'user_id' => factory(User::class),
    ];
});
