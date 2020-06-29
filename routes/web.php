<?php

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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/admin', 'UserController@index')->name('admin');

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], static function () {
    Route::resource('article', 'ArticleController');
    Route::get('all/{type}', 'ArticleController@all')->name('articles.all');
    Route::post('update', 'ArticleController@update_ajax')->name('article.update.ajax');
    Route::get('restore', 'ArticleController@restore')->name('article.restore');
    Route::get('kill', 'ArticleController@kill')->name('article.kill');
    Route::get('massremove', 'ArticleController@massRemove')->name('article.massremove');
    Route::get('clone', 'ArticleController@clone')->name('article.clone');

    Route::resource('place', 'PlaceController');
    Route::get('p-all/{type}', 'PlaceController@all')->name('place.all');
    Route::get('p-massremove', 'PlaceController@massRemove')->name('place.massremove');
    Route::get('p-kill', 'PlaceController@kill')->name('place.kill');
    Route::get('p-restore', 'PlaceController@restore')->name('place.restore');
    Route::post('p-update', 'PlaceController@updateAjax')->name('place.update.ajax');
    Route::get('p-clone', 'PlaceController@clone')->name('place.clone');

    Route::resource('service', 'ServicesController');
    Route::get('s-all/{type}', 'ServicesController@all')->name('service.all');
    Route::get('s-massremove', 'ServicesController@massRemove')->name('service.massremove');
    Route::get('s-restore', 'ServicesController@restore')->name('service.restore');
    Route::get('s-kill', 'ServicesController@kill')->name('service.kill');

    Route::resource('service-article', 'ServicesArticleController');
    Route::get('sa-all/{type}', 'ServicesArticleController@all')->name('sa.all');
    Route::get('sa-kill', 'ServicesArticleController@kill')->name('sa.kill');
    Route::get('sa-massremove', 'ServicesArticleController@massRemove')->name('sa.massremove');
    Route::get('sa-restore', 'ServicesArticleController@restore')->name('sa.restore');
    Route::post('sa-update', 'ServicesArticleController@updateAjax')->name('sa.update.ajax');

    Route::resource('baranggays','BaranggayController');
    Route::get('ba/{type}', 'BaranggayController@all')->name('ba.all');
    Route::get('ba-massremove', 'BaranggayController@massRemove')->name('ba.massremove');
    Route::get('ba-restore', 'BaranggayController@restore')->name('ba.restore');
    Route::get('ba-kill', 'BaranggayController@kill')->name('ba.kill');
    Route::get('ba-clone', 'BaranggayController@clone')->name('ba.clone');
    Route::post('ba-update', 'BaranggayController@updateAjax')->name('ba.update.ajax');

    Route::resource('officials','BaranggayOfficialController');
    Route::get('bo/{type}', 'BaranggayOfficialController@all')->name('bo.all');
    Route::get('bo-massremove', 'BaranggayOfficialController@massRemove')->name('bo.massremove');
    Route::get('bo-restore', 'BaranggayOfficialController@restore')->name('bo.restore');
    Route::get('bo-kill', 'BaranggayOfficialController@kill')->name('bo.kill');
    Route::post('bo-update', 'BaranggayOfficialController@ajaxUpdate')->name('bo.ajaxUpdate');
    Route::post('bo-group','BaranggayOfficialController@storeGroup')->name('bo.group');
    Route::get('bo-clone', 'BaranggayOfficialController@clone')->name('bo.clone');


    Route::resource('activities','ActivityController');
    Route::get('act-all/{type}', 'ActivityController@all')->name('act.all');
    Route::get('act-massremove', 'ActivityController@massRemove')->name('act.massremove');
    Route::get('act-restore', 'ActivityController@restore')->name('act.restore');
    Route::get('act-kill', 'ActivityController@kill')->name('act.kill');
    Route::get('act-clone', 'ActivityController@clone')->name('act.clone');
    Route::post('act-update', 'ActivityController@ajaxUpdate')->name('activities.update.ajax');

    Route::post('resize-update', 'ActivityController@ajaxUpdateFullCalendar')->name('fc.resize');

    Route::resource('transparency', 'TransparencyController');
    Route::get('transparency-all', 'TransparencyController@all');
    Route::get('transparency/{id}/delete', 'TransparencyController@delete')->name('transparency.delete');

    Route::resource('transparency-posts', 'TransparencyPostController');
    Route::get('post-all/{type}', 'TransparencyPostController@all');
    Route::get('post-massremove', 'TransparencyPostController@massRemove')->name('post.massremove');
    Route::get('post-restore', 'TransparencyPostController@restore')->name('post.restore');
    Route::get('post-kill', 'TransparencyPostController@kill')->name('post.kill');
    Route::post('post-update', 'TransparencyPostController@update_ajax')->name('post.transparency.update');

    Route::resource('departments', 'DepartmentCategoriesController');
    Route::get('departments-all', 'DepartmentCategoriesController@all')->name('departments.all');
    Route::get('departments-kill', 'DepartmentCategoriesController@kill')->name('departments.kill');

    Route::resource('department-offices', 'DepartmentOfficesController');
    Route::get('department-offices-all/{type}', 'DepartmentOfficesController@all')->name('department-offices.all');
    Route::get('department-offices-kill', 'DepartmentOfficesController@massRemove')->name('department-offices.massremove');
    Route::post('department-offices-updated', 'DepartmentOfficesController@updateOffice')->name('department-offices.updated');

    Route::resource('file-upload', 'TransparencyFileController');
    Route::get('file-render', 'TransparencyFileController@render')->name('file.render');
    Route::post('file-mass-remove', 'TransparencyFileController@mass_remove')->name('file.mass.remove');

    Route::resource('messages', 'MessageController');
    Route::get('messages-all/{type}', 'MessageController@all')->name('messages.all');
});
