<?php

use App\ServicesArticle;
use Illuminate\Database\Seeder;

class ServicesArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(ServicesArticle::class, 50)->create();
    }
}
