<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Place;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*id, user_id, name, description, categories, address, avatar*/
$factory->define(Place::class, static function (Faker $faker) {
    $name = $faker->sentence($nbWords = 6, $variableNbWords = true);
    $slug = Str::slug($name);
    return [
        'user_id' => 1,
        'name' => $name,
        'slug' => $slug,
        'short_description' => $faker->text,
        'description' => $faker->text,
        'categories' => 'uncategories',
        'address' => $faker->streetAddress,
        'status' => random_int(0,1),
        'created_at' => \Carbon\Carbon::now()
    ];
});


