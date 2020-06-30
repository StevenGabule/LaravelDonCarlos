<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Message;
use Faker\Generator as Faker;

$factory->define(Message::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'to' => $faker->safeEmail,
        'subject' => $faker->text,
        'email' => $faker->safeEmail,
        'message' => $faker->paragraph(),
        'status' => 0,
        'label' => 3,
    ];
});
