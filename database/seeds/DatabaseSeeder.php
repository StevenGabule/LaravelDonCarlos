<?php

use App\Article;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        factory(Article::class, 100)->create();
    }
}
