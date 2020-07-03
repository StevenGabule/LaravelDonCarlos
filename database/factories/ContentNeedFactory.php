<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ContentNeed;
use Carbon\Carbon;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(ContentNeed::class, function (Faker $faker) {
    return [
        'title' => Str::substr($faker->text, 0, 50),
        'slug' => $faker->slug,
        'short_description' => Str::substr($faker->text, 0, 150),
        'description' => 'Content here...',
        'status' => $faker->boolean,
        'user_id' => 1,
        'need_type' => mt_rand(1,2),
        'created_at' => Carbon::now(),
    ];
});
