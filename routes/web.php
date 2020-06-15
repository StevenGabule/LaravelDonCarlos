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
    Route::get('all/{type}', 'ArticleController@all')->name('articles.all');
    Route::resource('article', 'ArticleController');

    Route::get('massremove', 'ArticleController@massRemove')->name('article.massremove');
//    Route::get('trash', 'ArticleController@trash')->name('article.trash');
});
