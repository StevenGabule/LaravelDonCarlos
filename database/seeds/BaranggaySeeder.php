<?php

use App\Baranggay;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Str;


class BaranggaySeeder extends Seeder
{
    public function run(Faker $faker)
    {

        $baranggays = [
            [
                'name' => 'BARANGAY BAGONTAAS',
                'user_id' => 1,
                'slug' => Str::slug("BARANGAY BAGONTAAS"),
                'short_description' => $faker->text,
                'description' => $faker->paragraphs(10, true),
                'population' => random_int(200, 1000),
                'status' => random_int(0, 1),
                'address' => $faker->address,
                'avatar' => null,
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'BARANGAY MAAPAG',
                'user_id' => 1,
                'slug' => Str::slug('BARANGAY MAAPAG'),
                'short_description' => $faker->text,
                'description' => $faker->paragraphs(10, true),
                'population' => random_int(200, 1000),
                'status' => random_int(0, 1),
                'address' => $faker->address,
                'avatar' => null,
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'BARANGAY BANLAG',
                'user_id' => 1,
                'slug' => Str::slug('BARANGAY BANLAG'),
                'short_description' => $faker->text,
                'description' => $faker->paragraphs(10, true),
                'status' => random_int(0, 1),
                'population' => random_int(200, 1000),
                'address' => $faker->address,
                'avatar' => null,
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'BARANGAY MABUHAY',
                'user_id' => 1,
                'slug' => Str::slug('BARANGAY MABUHAY'),
                'status' => random_int(0, 1),
                'short_description' => $faker->text,
                'description' => $faker->paragraphs(10, true),
                'population' => random_int(200, 1000),
                'address' => $faker->address,
                'avatar' => null,
                'created_at' => Carbon::now()
            ], [
                'name' => 'BARANGAY BAROBO',
                'user_id' => 1,
                'status' => random_int(0, 1),
                'slug' => Str::slug('BARANGAY BAROBO'),
                'short_description' => $faker->text,
                'description' => $faker->paragraphs(10, true),
                'population' => random_int(200, 1000),
                'address' => $faker->address,
                'avatar' => null,
                'created_at' => Carbon::now()
            ], [
                'name' => 'BARANGAY MAILAG',
                'user_id' => 1,
                'slug' => Str::slug('BARANGAY MAILAG'),
                'status' => random_int(0, 1),
                'short_description' => $faker->text,
                'description' => $faker->paragraphs(10, true),
                'population' => random_int(200, 1000),
                'address' => $faker->address,
                'avatar' => null,
                'created_at' => Carbon::now()
            ], [
                'name' => 'BARANGAY BATANGAN',
                'user_id' => 1,
                'slug' => Str::slug('BARANGAY BATANGAN'),
                'status' => random_int(0, 1),
                'short_description' => $faker->text,
                'description' => $faker->paragraphs(10, true),
                'population' => random_int(200, 1000),
                'address' => $faker->address,
                'avatar' => null,
                'created_at' => Carbon::now()
            ], [
                'name' => 'BARANGAY BULACAN',
                'user_id' => 1,
                'slug' => Str::slug('BARANGAY BULACAN'),
                'short_description' => $faker->text,
                'description' => $faker->paragraphs(10, true),
                'status' => random_int(0, 1),
                'population' => random_int(200, 1000),
                'address' => $faker->address,
                'avatar' => null,
                'created_at' => Carbon::now()
            ], [
                'name' => 'BARANGAY MT. NEBO',
                'user_id' => 1,
                'slug' => Str::slug('BARANGAY MT. NEBO'),
                'status' => random_int(0, 1),
                'short_description' => $faker->text,
                'description' => $faker->paragraphs(10, true),
                'population' => random_int(200, 1000),
                'address' => $faker->address,
                'avatar' => null,
                'created_at' => Carbon::now()
            ], [
                'name' => 'BARANGAY CATUMBALON',
                'user_id' => 1,
                'slug' => Str::slug('BARANGAY CATUMBALON'),
                'status' => random_int(0, 1),
                'short_description' => $faker->text,
                'description' => $faker->paragraphs(10, true),
                'population' => random_int(200, 1000),
                'address' => $faker->address,
                'avatar' => null,
                'created_at' => Carbon::now()
            ], [
                'name' => 'BARANGAY NABAG-O',
                'user_id' => 1,
                'slug' => Str::slug('BARANGAY NABAG-O'),
                'short_description' => $faker->text,
                'description' => $faker->paragraphs(10, true),
                'status' => random_int(0, 1),
                'population' => random_int(200, 1000),
                'address' => $faker->address,
                'avatar' => null,
                'created_at' => Carbon::now()
            ],
        ];
        Baranggay::insert($baranggays);
    }
}
