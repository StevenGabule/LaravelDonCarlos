<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Transparency;
use App\TransparencyPost;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(TransparencyPost::class, function (Faker $faker) {
    $title = substr($faker->text, 0, 50);
    $slug = Str::slug($title);
    return [
        /*user_id, transparency_id, title, short_descriptiom, description, views */
        'user_id' => 1,
        'transparency_id' => Transparency::pluck('id')->random(),
        'title' => $title,
        'slug' => $slug,
        'status' => random_int(0, 1),
        'short_description' => substr($faker->text, 0, 50),
        'description' => $faker->paragraphs(3, true),
        'views' => random_int(100, 10000)
    ];
});
