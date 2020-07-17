<?php

use App\TransparencyPost;
use Illuminate\Database\Seeder;

class TransparencyPostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(TransparencyPost::class, 100)->create();
    }
}
