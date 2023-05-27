<?php

  use App\ArticleCategory;
  use App\DepartmentCategories;
  use App\PageContent;
  use App\Services;
  use App\Transparency;
  use App\User;
  use Carbon\Carbon;
  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Auth;
  use Illuminate\Support\Facades\Route;
  use Illuminate\Support\Str;

  Route::get('/', 'PageController@index')->name('index');

  Route::get('/services', 'PageController@services')->name('services');
  Route::get('/services/{id}', 'PageController@services_show')->name('services.show');
  Route::get('/service/{id}/{slug}', 'PageController@service_show_detail')->name('services.show.detail');

  Route::get('/about-don-carlos', 'PageController@about')->name('about');
  Route::get('/about-don-carlos/baranggay', 'PageController@about_baranggay')->name('about.baranggay');
  Route::get('/about-don-carlos/baranggay/{slug}', 'PageController@about_baranggay_detail')->name('about.baranggay.detail');

  Route::get('/transparency', 'PageController@transparency')->name('transparency');
  Route::get('/transparent/{slug}', 'PageController@transparencyShow')->name('transparency.page.show');
  Route::get('/transparency/{slug}/article/{slug1}', 'PageController@transparencyDetail')->name('transparency.detail.show');

  Route::get('/news', 'PageController@news')->name('news');
  Route::get('/news/{slug}', 'PageController@news_details')->name('news.detail');

  Route::get('/tourism', 'PageController@tourism')->name('tourism');
  Route::get('/place/{slug}', 'PageController@tourismShow')->name('tourism.show');

  Route::get('/events', 'PageController@activities')->name('events');
  Route::get('/events/{slug}', 'PageController@activitiesShowData')->name('event.show');

  Route::get('/contacts', 'PageController@contacts')->name('contacts');
  Route::get('/contact', 'PageController@sending')->name('sending');

  Route::get('/departments', 'PageController@departments')->name('departments');
  Route::get('/department/{id}/{slug}', 'PageController@department_lists')->name('departments.list');
  Route::get('/department/{id}/{slug1}/{slug2}', 'PageController@department_list_show')->name('departments.list.show');

  Auth::routes();

  Route::get('/home', 'HomeController@index')->name('home');

  Route::get('/features/{slug}', 'PageController@page_show')->name('page.show');
  Route::get('/don-carlos/awards', 'PageController@award')->name('awards');
  Route::get('/don-carlos/mandate', 'PageController@mandate')->name('mandate');
  Route::get('/don-carlos/{type}/{slug}', 'PageController@content_show')->name('content.show');

  Route::get('/transparent/download/{id}', 'DownloadFileController@download')->name('transparent.download');

  Route::group(
    ['prefix' => 'admin', 'middleware' => 'auth'],
    static function () {
      Route::get('/', 'UserController@index')->name('admin');

      // NEWS AND UPDATES ROUTES
      Route::resource('article', 'ArticleController');
      Route::get('all/{type}', 'ArticleController@all')->name('articles.all');
      Route::post('update', 'ArticleController@update_ajax')->name('article.update.ajax');
      Route::get('restore', 'ArticleController@restore')->name('article.restore');
      Route::delete('kill/{id}', 'ArticleController@kill')->name('article.kill');
      Route::get('massremove', 'ArticleController@massRemove')->name('article.massremove');
      Route::get('clone', 'ArticleController@clone')->name('article.clone');

      // PLACES ROUTES
      Route::resource('place', 'PlaceController');
      Route::get('p-all/{type}', 'PlaceController@all')->name('place.all');
      Route::get('p-massremove', 'PlaceController@massRemove')->name('place.massremove');
      Route::delete('p-kill/{ids}', 'PlaceController@kill')->name('place.kill');
      Route::get('p-restore', 'PlaceController@restore')->name('place.restore');
      Route::post('p-update', 'PlaceController@updateAjax')->name('place.update.ajax');
      Route::get('p-clone', 'PlaceController@clone')->name('place.clone');

      // SERVICES ROUTES
      Route::resource('service', 'ServicesController');
      Route::get('s-all/{type}', 'ServicesController@all')->name('service.all');
      Route::get('s-massremove', 'ServicesController@massRemove')->name('service.massremove');
      Route::get('s-restore', 'ServicesController@restore')->name('service.restore');
      Route::get('s-kill', 'ServicesController@kill')->name('service.kill');

      // SERVICES ARTICLE ROUTES
      Route::resource('service-article', 'ServicesArticleController');
      Route::get('sa-all/{type}', 'ServicesArticleController@all')->name('sa.all');
      Route::delete('sa-kill/{ids}', 'ServicesArticleController@kill')->name('sa.kill');
      Route::get('sa-massremove', 'ServicesArticleController@massRemove')->name('sa.massremove');
      Route::get('sa-restore', 'ServicesArticleController@restore')->name('sa.restore');
      Route::post('sa-update', 'ServicesArticleController@updateAjax')->name('sa.update.ajax');

      // BARANGGAY ROUTES
      Route::resource('baranggays', 'BaranggayController');
      Route::get('ba/{type}', 'BaranggayController@all')->name('ba.all');
      Route::get('ba-massremove', 'BaranggayController@massRemove')->name('ba.massremove');
      Route::get('ba-restore', 'BaranggayController@restore')->name('ba.restore');
      Route::delete('ba-kill/{ids}', 'BaranggayController@kill')->name('ba.kill');
      Route::get('ba-clone', 'BaranggayController@clone')->name('ba.clone');
      Route::post('ba-update', 'BaranggayController@updateAjax')->name('ba.update.ajax');

      // BARANGGAY OFFICIALS ROUTES
      Route::resource('officials', 'BaranggayOfficialController');
      Route::get('bo/{type}', 'BaranggayOfficialController@all')->name('bo.all');
      Route::get('bo-massremove', 'BaranggayOfficialController@massRemove')->name('bo.massremove');
      Route::get('bo-restore', 'BaranggayOfficialController@restore')->name('bo.restore');
      Route::delete('bo-kill/{ids}', 'BaranggayOfficialController@kill')->name('bo.kill');
      Route::post('bo-update', 'BaranggayOfficialController@ajaxUpdate')->name('bo.ajaxUpdate');
      Route::post('bo-group', 'BaranggayOfficialController@storeGroup')->name('bo.group');
      Route::get('bo-clone', 'BaranggayOfficialController@clone')->name('bo.clone');

      // ACTIVITIES AND EVENTS ROUTES
      Route::resource('activities', 'ActivityController');
      Route::get('act-all/{type}', 'ActivityController@all')->name('act.all');
      Route::get('act-massremove', 'ActivityController@massRemove')->name('act.massremove');
      Route::get('act-restore', 'ActivityController@restore')->name('act.restore');
      Route::delete('act-kill/{ids}', 'ActivityController@kill')->name('act.kill');
      Route::get('act-clone', 'ActivityController@clone')->name('act.clone');
      Route::post('act-update', 'ActivityController@ajaxUpdate')->name('activities.update.ajax');

      // CALENDAR ROUTES
      Route::post('resize-update', 'ActivityController@ajaxUpdateFullCalendar')->name('fc.resize');

      // TRANSPARENCY MANAGEMENT ROUTES
      Route::resource('transparency', 'TransparencyController');
      Route::get('transparency-all', 'TransparencyController@all');
      Route::get('transparency/{id}/delete', 'TransparencyController@delete')->name('transparency.delete');

      // TRANSPARENT POST MANAGEMENT ROUTES
      Route::resource('transparency-posts', 'TransparencyPostController');
      Route::get('post-all/{type}', 'TransparencyPostController@all');
      Route::get('post-massremove', 'TransparencyPostController@massRemove')->name('post.massremove');
      Route::get('post-restore', 'TransparencyPostController@restore')->name('post.restore');
      Route::get('post-kill', 'TransparencyPostController@kill')->name('post.kill');
      Route::post('post-update', 'TransparencyPostController@update_ajax')->name('post.transparency.update');

      // DEPARTMENT MANAGEMENT ROUTES
      Route::resource('departments', 'DepartmentCategoriesController');
      Route::get('departments-all', 'DepartmentCategoriesController@all')->name('departments.all');
      Route::get('departments-kill', 'DepartmentCategoriesController@kill')->name('departments.kill');

      // DEPARTMENT OFFICES MANAGEMENT ROUTES
      Route::resource('department-offices', 'DepartmentOfficesController');
      Route::get('department-offices-all/{type}', 'DepartmentOfficesController@all')->name('department-offices.all');
      Route::get('department-offices-kill', 'DepartmentOfficesController@massRemove')->name('department-offices.massremove');
      Route::delete('department-offices-kill-real/{ids}', 'DepartmentOfficesController@destroyOffices')->name('department-offices.destroy');
      Route::post('department-offices-updated', 'DepartmentOfficesController@updateOffice')->name('department-offices.updated');

      // FILE MANAGEMENT ROUTES
      Route::resource('file-upload', 'TransparencyFileController');
      Route::get('file-render', 'TransparencyFileController@render')->name('file.render');
      Route::delete('file-mass-remove/{ids}', 'TransparencyFileController@mass_remove')->name('file.mass.remove');

      // MESSAGES ROUTES
      Route::resource('messages', 'MessageController');
      Route::get('messages-all/{type}', 'MessageController@all')->name('messages.all');
      Route::get('fetch-mail', 'MessageController@fetch')->name('fetch.email');
      Route::get('message-remove', 'MessageController@remove')->name('message.remove');
      Route::get('message-restore', 'MessageController@restore')->name('message.restore');
      Route::get('message-kill', 'MessageController@kill')->name('message.kill');

      // ACCOUNTS ROUTES
      Route::get('accounts', 'UserController@users')->name('accounts');
      Route::get('accounts-all', 'UserController@all')->name('accounts.all');
      Route::post('account-store', 'UserController@store')->name('account.store');
      Route::get('account-edit', 'UserController@edit')->name('account.edit');
      Route::post('account-update', 'UserController@update')->name('account.update');
      Route::post('account-update-password', 'UserController@update_password')->name('account.update.password');
      Route::get('account-destroy/{id}', 'UserController@destroy')->name('account.destroy');

      // PAGE CONTENT ROUTES
      Route::resource('page-content', 'PageContentController');
      Route::get('page-content-all', 'PageContentController@all')->name('page_content.all');
      Route::post('page-content-update', 'PageContentController@update_ajax')->name('page_content.update');

      // NEED CONTENT ROUTES
      Route::resource('need-content', 'ContentNeedController');
      Route::get('need-content-all/{type}', 'ContentNeedController@all')->name('need_content.all');
      Route::post('need-content-update', 'ContentNeedController@update_ajax')->name('need_content.update');
      Route::get('need-content-clone', 'ContentNeedController@clone')->name('need_content.clone');
      Route::get('need-content-mass_remove', 'ContentNeedController@remove')->name('need_content.mass_remove');
      Route::get('need-content-mass_restore', 'ContentNeedController@restore')->name('need_content.mass_restore');
      Route::delete('need-content-mass_kill/{ids}', 'ContentNeedController@kill')->name('need_content.mass_kill');

      // hotlines
      Route::resource('hotlines', 'HotlineController');
      Route::resource('hotlines_category', 'HotlineCategoryController');
    }
  );

  // *** manual encoding
  Route::get('/parse-data', function (Request $requests) {
    $categories = [
      ['name' => 'Personalize'],
      ['name' => 'Coronavirus'],
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

    DepartmentCategories::create([
      'name' => 'Economic Development',
      'slug' => Str::slug('Economic Development'),
      'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. In quia ut voluptatem. Ad animi commodi facilis possimus quae quo reprehenderit.',
      'created_at' => Carbon::now()
    ]);

    DepartmentCategories::create([
      'name' => 'Fiscal Development',
      'slug' => Str::slug('Fiscal Development'),
      'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. In quia ut voluptatem. Ad animi commodi facilis possimus quae quo reprehenderit.',
      'created_at' => Carbon::now()
    ]);

    DepartmentCategories::create([
      'name' => 'Infrastructure Development',
      'slug' => Str::slug('Infrastructure Development'),
      'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. In quia ut voluptatem. Ad animi commodi facilis possimus quae quo reprehenderit.',
      'created_at' => Carbon::now()
    ]);

    DepartmentCategories::create([
      'name' => 'Public Administration',
      'slug' => Str::slug('Public Administration'),
      'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. In quia ut voluptatem. Ad animi commodi facilis possimus quae quo reprehenderit.',
      'created_at' => Carbon::now()
    ]);

    DepartmentCategories::create([
      'name' => 'Social Service',
      'slug' => Str::slug('Social Service'),
      'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. In quia ut voluptatem. Ad animi commodi facilis possimus quae quo reprehenderit.',
      'created_at' => Carbon::now()
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

    PageContent::create([
      'title' => 'Infrastructure',
      'slug' => Str::slug('infrastructure'),
      'short_description' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et',
      'description' => 'Content here...',
      'created_at' => Carbon::now()
    ]);

    PageContent::create([
      'title' => 'Agriculture',
      'slug' => Str::slug('agriculture'),
      'short_description' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et',
      'description' => 'Content here...',
      'created_at' => Carbon::now()
    ]);

    PageContent::create([
      'title' => 'Healthcare',
      'slug' => Str::slug('healthcare'),
      'short_description' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et',
      'description' => 'Content here...',
      'created_at' => Carbon::now()
    ]);

    PageContent::create([
      'title' => 'Education',
      'slug' => Str::slug('education'),
      'short_description' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et',
      'description' => 'Content here...',
      'created_at' => Carbon::now()
    ]);

    PageContent::create([
      'title' => 'Tourism',
      'slug' => Str::slug('tourism'),
      'short_description' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et',
      'description' => 'Content here...',
      'created_at' => Carbon::now()
    ]);

    $faker = Faker\Factory::create();

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
    Services::insert($services);


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
    Transparency::insert($transparency);

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

    echo 'seed completed';
  });
