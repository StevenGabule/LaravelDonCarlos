<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CategoriesSeeder::class,
            ServicesSeeder::class,
            BaranggaySeeder::class,
            TransparencyCategoriesSeeder::class,
            UsersSeeder::class,
            ArticlesSeeder::class,
            PlaceSeeder::class,
            ServicesArticleSeeder::class,
            BaranggayOfficialsSeeder::class,
            ActivitiesSeeder::class,
            TransparencyPostsSeeder::class,
            ContentNeedSeeder::class,
            DepartmentCategoriesSeeder::class,
            PageContentSeeder::class,
        ]);

    }
}
