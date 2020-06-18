<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Services;
use App\ServicesArticle;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/**/
$factory->define(ServicesArticle::class, static function (Faker $faker) {
    $name = $faker->text;
    $slug = Str::slug($name, '-');
    return [
        'services_id' => Services::pluck('id')->random(),
        'user_id' => 1,
        'name' => $name,
        'slug' => $slug,
        'status' => random_int(0,1),
        'short_description' => $faker->text,
        'description' => $faker->paragraphs(10, true),
        'views' => random_int(1000, 2000),
    ];
});
