<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Activities;
use App\User;
use Carbon\Carbon;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Activities::class, static function (Faker $faker) {
    $title = $faker->sentence;
    $slug = Str::slug($title);
    return [
        'user_id' => User::pluck('id')->random(),
        'short_description' => $faker->text,
        'title' => $title,
        'slug' => $slug,
        'description' => $faker->paragraphs(10, true),
        'date_start' => $faker->dateTimeThisMonth('now', 'Asia/Manila'),
        'date_end' => $faker->dateTimeThisMonth('now', 'Asia/Manila'),
        'address' => $faker->address,
        'status' => random_int(0,1)
    ];
});
