<?php

use App\Article;
use App\ArticleCategory;
use App\Baranggay;
use App\Place;
use App\Services;
use App\ServicesArticle;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(Faker $faker): void
    {
        $categories = [
            ['name' => 'Personalize'],
            ['name' => 'Coronovirus'],
            ['name' => 'Top Headlines'],
            ['name' => 'Pinoy Buzz'],
            ['name' => 'News'],
            ['name' => 'Education'],
            ['name' => 'Sports'],
            ['name' => 'National'],
            ['name' => 'Entertainment'],
            ['name' => 'Money'],
            ['name' => 'Lifestyle'],
            ['name' => 'Video'],
            ['name' => 'World'],
            ['name' => 'Health And Fitness'],
            ['name' => 'Food And Drink'],
            ['name' => 'Travel'],
            ['name' => 'Tech and Science'],
        ];

        $services = [
            [
                'name' => 'Social Services',
                'short_description' => null,
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'Civil Register Services',
                'short_description' => null,
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'Online Payment',
                'short_description' => 'Skip the line and feel more convenient with Davao City’s online payment',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'Landmark Legislations',
                'short_description' => 'Davao City has pioneered in implementing local laws that made it a recognizable city in the Philippines',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'Career Opportunities',
                'short_description' => 'Davao City offers an array of employment opportunities for Dabawenyos.',
                'created_at' => Carbon::now(),
            ]
        ];
        /*id, name, short_description, description, population, address, avatar*/

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

        /*$official = [
           [
               'position' => random_int(1,5),
               'baranggay_id' => Baranggay::pluck('id')->random(),
               'from' => ''
           ]
        ];*/

        ArticleCategory::insert($categories);
        Services::insert($services);
        Baranggay::insert($baranggays);

        factory(User::class, 1)->create();
        factory(Article::class, 100)->create();
        factory(Place::class, 100)->create();
        factory(ServicesArticle::class, 50)->create();
    }
}
