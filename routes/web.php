<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', 'PageController@index')->name('index');
Route::get('/services', 'PageController@services')->name('services');
Route::get('/about-don-carlos', 'PageController@about')->name('about');
Route::get('/transparency', 'PageController@transparency')->name('transparency');
Route::get('/news', 'PageController@news')->name('news');
Route::get('/tourism', 'PageController@tourism')->name('tourism');
Route::get('/events', 'PageController@events')->name('events');
Route::get('/contacts', 'PageController@contacts')->name('contacts');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/admin', 'UserController@index')->name('admin');


Route::group(['prefix' => 'admin', 'middleware' => 'auth'], static function () {
    Route::resource('article', 'ArticleController');
    Route::get('all/{type}', 'ArticleController@all')->name('articles.all');
    Route::post('update', 'ArticleController@updateAjax')->name('article.update.ajax');
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

});
