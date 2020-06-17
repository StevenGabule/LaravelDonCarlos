<?php

use App\Place;
use Illuminate\Database\Seeder;

class PlaceSeeder extends Seeder
{
    public function run() : void
    {
        factory(Place::class, 100)->create();
    }
}
