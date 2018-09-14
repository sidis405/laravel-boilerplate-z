<?php

use Faker\Generator as Faker;

$factory->define(App\Post::class, function (Faker $faker) {
    return [
        'title' => ucfirst($faker->sentence),
        'preview' => $faker->sentences(3, true),
        'body' => $faker->paragraphs(5, true),
        'category_id' => factory(App\Category::class),
        'user_id' => factory(App\User::class),
    ];
});
