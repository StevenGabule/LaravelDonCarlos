<?php

use App\Activities;
use App\Article;
use App\ArticleCategory;
use App\Baranggay;
use App\BaranggayOfficial;
use App\ContentNeed;
use App\DepartmentCategories;
use App\PageContent;
use App\Place;
use App\Services;
use App\ServicesArticle;
use App\Transparency;
use App\TransparencyPost;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(Faker $faker): void
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

        $services = [
            [
                'name' => 'Social Services',
                'short_description' => Str::substr($faker->text, 0, 50),
                'status' => 1,
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'Civil Register Services',
                'short_description' => Str::substr($faker->text, 0, 50),
                'status' => 1,
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'Online Payment',
                'short_description' => 'Skip the line and feel more convenient with Davao City’s online payment',
                'status' => 1,
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'Landmark Legislations',
                'short_description' => 'Davao City has pioneered in implementing local laws that made it a recognizable city in the Philippines',
                'status' => 1,
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'Career Opportunities',
                'short_description' => 'Davao City offers an array of employment opportunities for Dabawenyos.',
                'status' => 1,
                'created_at' => Carbon::now(),
            ]
        ];
        /*id, name, short_description, description, population, address, avatar*/

        $baranggays = [
            [
                'name' => 'BARANGAY BAGONTAAS',
                'user_id' => 1,
                'slug' => Str::slug("BARANGAY BAGONTAAS"),
                'short_description' => $faker->text,
                'description' => $faker->paragraphs(10, true),
                'population' => random_int(200, 1000),
                'status' => random_int(0, 1),
                'address' => $faker->address,
                'avatar' => null,
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'BARANGAY MAAPAG',
                'user_id' => 1,
                'slug' => Str::slug('BARANGAY MAAPAG'),
                'short_description' => $faker->text,
                'description' => $faker->paragraphs(10, true),
                'population' => random_int(200, 1000),
                'status' => random_int(0, 1),
                'address' => $faker->address,
                'avatar' => null,
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'BARANGAY BANLAG',
                'user_id' => 1,
                'slug' => Str::slug('BARANGAY BANLAG'),
                'short_description' => $faker->text,
                'description' => $faker->paragraphs(10, true),
                'status' => random_int(0, 1),
                'population' => random_int(200, 1000),
                'address' => $faker->address,
                'avatar' => null,
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'BARANGAY MABUHAY',
                'user_id' => 1,
                'slug' => Str::slug('BARANGAY MABUHAY'),
                'status' => random_int(0, 1),
                'short_description' => $faker->text,
                'description' => $faker->paragraphs(10, true),
                'population' => random_int(200, 1000),
                'address' => $faker->address,
                'avatar' => null,
                'created_at' => Carbon::now()
            ], [
                'name' => 'BARANGAY BAROBO',
                'user_id' => 1,
                'status' => random_int(0, 1),
                'slug' => Str::slug('BARANGAY BAROBO'),
                'short_description' => $faker->text,
                'description' => $faker->paragraphs(10, true),
                'population' => random_int(200, 1000),
                'address' => $faker->address,
                'avatar' => null,
                'created_at' => Carbon::now()
            ], [
                'name' => 'BARANGAY MAILAG',
                'user_id' => 1,
                'slug' => Str::slug('BARANGAY MAILAG'),
                'status' => random_int(0, 1),
                'short_description' => $faker->text,
                'description' => $faker->paragraphs(10, true),
                'population' => random_int(200, 1000),
                'address' => $faker->address,
                'avatar' => null,
                'created_at' => Carbon::now()
            ], [
                'name' => 'BARANGAY BATANGAN',
                'user_id' => 1,
                'slug' => Str::slug('BARANGAY BATANGAN'),
                'status' => random_int(0, 1),
                'short_description' => $faker->text,
                'description' => $faker->paragraphs(10, true),
                'population' => random_int(200, 1000),
                'address' => $faker->address,
                'avatar' => null,
                'created_at' => Carbon::now()
            ], [
                'name' => 'BARANGAY BULACAN',
                'user_id' => 1,
                'slug' => Str::slug('BARANGAY BULACAN'),
                'short_description' => $faker->text,
                'description' => $faker->paragraphs(10, true),
                'status' => random_int(0, 1),
                'population' => random_int(200, 1000),
                'address' => $faker->address,
                'avatar' => null,
                'created_at' => Carbon::now()
            ], [
                'name' => 'BARANGAY MT. NEBO',
                'user_id' => 1,
                'slug' => Str::slug('BARANGAY MT. NEBO'),
                'status' => random_int(0, 1),
                'short_description' => $faker->text,
                'description' => $faker->paragraphs(10, true),
                'population' => random_int(200, 1000),
                'address' => $faker->address,
                'avatar' => null,
                'created_at' => Carbon::now()
            ], [
                'name' => 'BARANGAY CATUMBALON',
                'user_id' => 1,
                'slug' => Str::slug('BARANGAY CATUMBALON'),
                'status' => random_int(0, 1),
                'short_description' => $faker->text,
                'description' => $faker->paragraphs(10, true),
                'population' => random_int(200, 1000),
                'address' => $faker->address,
                'avatar' => null,
                'created_at' => Carbon::now()
            ], [
                'name' => 'BARANGAY NABAG-O',
                'user_id' => 1,
                'slug' => Str::slug('BARANGAY NABAG-O'),
                'short_description' => $faker->text,
                'description' => $faker->paragraphs(10, true),
                'status' => random_int(0, 1),
                'population' => random_int(200, 1000),
                'address' => $faker->address,
                'avatar' => null,
                'created_at' => Carbon::now()
            ],
        ];

        $transparency = [
            [
                'title' => 'IATF OMNIBUS GUIDELINES ON THE IMPLEMENTATION OF COMMUNITY QUARANTINE IN THE PHILIPPINES',
                'slug' => Str::slug('IATF OMNIBUS GUIDELINES ON THE IMPLEMENTATION OF COMMUNITY QUARANTINE IN THE PHILIPPINES'),
                'short_description' => substr($faker->text, 0, 50),
                'created_at' => Carbon::now()
            ],
            [
                'title' => 'COVID-19 RISK ASSESSMENT MAP',
                'slug' => Str::slug('COVID-19 RISK ASSESSMENT MAP'),
                'short_description' => substr($faker->text, 0, 50),
                'created_at' => Carbon::now()
            ],
            [
                'title' => 'DAVAO CITY TRAVEL ORDER',
                'slug' => Str::slug('DAVAO CITY TRAVEL ORDER'),
                'short_description' => substr($faker->text, 0, 50),
                'created_at' => Carbon::now()
            ],
            [
                'title' => 'ARTICLES',
                'slug' => Str::slug('ARTICLES'),
                'short_description' => substr($faker->text, 0, 50),
                'created_at' => Carbon::now()
            ],
        ];


        ArticleCategory::insert($categories);
        Services::insert($services);
        Baranggay::insert($baranggays);
        Transparency::insert($transparency);

        factory(User::class, 1)->create();
        factory(Article::class, 100)->create();
        factory(Place::class, 100)->create();
        factory(ServicesArticle::class, 50)->create();
        factory(BaranggayOfficial::class, 100)->create();
        factory(Activities::class, 50)->create();
        factory(TransparencyPost::class, 100)->create();
        factory(ContentNeed::class, 100)->create();

        User::create([
            'name' => 'Admin Muck',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'name' => 'Admin Mock',
            'email' => 'admin2@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        PageContent::create([
            'title' => 'Don Carlos Domestic Airport',
            'slug' => Str::slug('Don Carlos Domestic Airport'),
            'short_description' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et',
            'description' => 'Content herer...',
            'created_at' => Carbon::now()
        ]);

        PageContent::create([
            'title' => 'Meet Woman Who Care About Our City',
            'slug' => Str::slug('Meet Woman Who Care About Our City'),
            'short_description' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et',
            'description' => 'Content here...',
            'created_at' => Carbon::now()
        ]);


        PageContent::create([
            'title' => 'History Of Don Carlos Bukidnon',
            'slug' => Str::slug('History Of Don Carlos Bukidnon'),
            'short_description' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et',
            'description' => 'Content here...',
            'created_at' => Carbon::now()
        ]);


        PageContent::create([
            'title' => 'Mission and Vision',
            'slug' => Str::slug('Mission and Vision'),
            'short_description' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et',
            'description' => 'Content here...',
            'created_at' => Carbon::now()
        ]);

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
