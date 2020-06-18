<?php

use App\Article;
use App\ArticleCategory;
use App\Place;
use App\Services;
use App\ServicesArticle;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
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

        ArticleCategory::insert($categories);
        Services::insert($services);

        factory(User::class, 1)->create();
        factory(Article::class, 100)->create();
        factory(Place::class, 100)->create();
        factory(ServicesArticle::class, 50)->create();
    }
}
