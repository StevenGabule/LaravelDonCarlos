<?php

use App\Services;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

class ServicesSeeder extends Seeder
{

    public function run(Faker $faker)
    {
        $services = [
            [
                'name' => 'Social Services',
                'short_description' => Str::substr($faker->text, 0, 50),
                'status' => 1,
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'Civil Register Services',
                'short_description' => Str::substr($faker->text, 0, 50),
                'status' => 1,
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'Online Payment',
                'short_description' => 'Skip the line and feel more convenient with Davao City’s online payment',
                'status' => 1,
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'Landmark Legislations',
                'short_description' => 'Davao City has pioneered in implementing local laws that made it a recognizable city in the Philippines',
                'status' => 1,
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'Career Opportunities',
                'short_description' => 'Davao City offers an array of employment opportunities for Dabawenyos.',
                'status' => 1,
                'created_at' => Carbon::now(),
            ]
        ];
        Services::insert($services);

    }
}
