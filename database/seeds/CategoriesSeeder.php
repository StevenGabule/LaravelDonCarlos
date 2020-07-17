<?php

use App\ArticleCategory;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
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
    }
}
