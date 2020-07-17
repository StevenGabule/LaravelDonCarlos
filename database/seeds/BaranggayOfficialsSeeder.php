<?php

use App\BaranggayOfficial;
use Illuminate\Database\Seeder;

class BaranggayOfficialsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(BaranggayOfficial::class, 100)->create();
    }
}
