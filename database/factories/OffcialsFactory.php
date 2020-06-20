<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Baranggay;
use App\BaranggayOfficial;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(BaranggayOfficial::class, function (Faker $faker) {
    return [
        'baranggay_id' => Baranggay::pluck('id')->random(),
        'name' => $faker->firstName,
        'position' => random_int(1,5),
        'from' => date('Y'),
        'to' => date('Y'),
        'avatar' => null,
        'status' => random_int(0,1),
        'created_at' => Carbon::now()
    ];
});
