<?php

use App\Article;
use App\ArticleCategory;
use App\Place;
use App\User;
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

        ArticleCategory::insert($categories);

        factory(User::class, 1)->create();
        factory(Article::class, 100)->create();
        factory(Place::class, 100)->create();
    }
}
