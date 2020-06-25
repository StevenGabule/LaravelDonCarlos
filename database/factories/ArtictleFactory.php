<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Article;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Article::class, static function (Faker $faker) {
    $title = $faker->text;
    $slug = Str::slug($title, '-');
    return [
        'user_id' => 1,
        'title' => $title,
        'slug' => $slug,
        'short_description' => $faker->text,
        'description' => $faker->paragraphs(3, true),
        'status' => random_int(0,1),
        'category_id' => random_int(1,17),
        'avatar' => null
    ];
});
