<?php

use App\DepartmentCategories;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DepartmentCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DepartmentCategories::create([
            'name' => 'Economic Development',
            'slug' => Str::slug('Economic Development'),
            'description' => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. In quia ut voluptatem. Ad animi commodi facilis possimus quae quo reprehenderit.",
            'created_at' => Carbon::now()
        ]);

        DepartmentCategories::create([
            'name' => 'Fiscal Development',
            'slug' => Str::slug('Fiscal Development'),
            'description' => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. In quia ut voluptatem. Ad animi commodi facilis possimus quae quo reprehenderit.",
            'created_at' => Carbon::now()
        ]);

        DepartmentCategories::create([
            'name' => 'Infrastructure Development',
            'slug' => Str::slug('Infrastructure Development'),
            'description' => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. In quia ut voluptatem. Ad animi commodi facilis possimus quae quo reprehenderit.",
            'created_at' => Carbon::now()
        ]);

        DepartmentCategories::create([
            'name' => 'Public Administration',
            'slug' => Str::slug('Public Administration'),
            'description' => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. In quia ut voluptatem. Ad animi commodi facilis possimus quae quo reprehenderit.",
            'created_at' => Carbon::now()
        ]);

        DepartmentCategories::create([
            'name' => 'Social Service',
            'slug' => Str::slug('Social Service'),
            'description' => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. In quia ut voluptatem. Ad animi commodi facilis possimus quae quo reprehenderit.",
            'created_at' => Carbon::now()
        ]);
    }
}
