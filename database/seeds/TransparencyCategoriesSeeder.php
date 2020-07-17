<?php

use App\Transparency;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class TransparencyCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        /*id, name, short_description, description, population, address, avatar*/

        $transparency = [
            [
                'title' => 'IATF OMNIBUS GUIDELINES ON THE IMPLEMENTATION OF COMMUNITY QUARANTINE IN THE PHILIPPINES',
                'slug' => Str::slug('IATF OMNIBUS GUIDELINES ON THE IMPLEMENTATION OF COMMUNITY QUARANTINE IN THE PHILIPPINES'),
                'short_description' => substr($faker->text, 0, 50),
                'created_at' => Carbon::now()
            ],
            [
                'title' => 'COVID-19 RISK ASSESSMENT MAP',
                'slug' => Str::slug('COVID-19 RISK ASSESSMENT MAP'),
                'short_description' => substr($faker->text, 0, 50),
                'created_at' => Carbon::now()
            ],
            [
                'title' => 'DAVAO CITY TRAVEL ORDER',
                'slug' => Str::slug('DAVAO CITY TRAVEL ORDER'),
                'short_description' => substr($faker->text, 0, 50),
                'created_at' => Carbon::now()
            ],
            [
                'title' => 'ARTICLES',
                'slug' => Str::slug('ARTICLES'),
                'short_description' => substr($faker->text, 0, 50),
                'created_at' => Carbon::now()
            ],
        ];
        Transparency::insert($transparency);
    }
}
