<?php

use App\ContentNeed;
use Illuminate\Database\Seeder;

class ContentNeedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(ContentNeed::class, 100)->create();
    }
}
