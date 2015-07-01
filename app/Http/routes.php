<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'ArticlesController@index');

Route::get('myArticles', 'ArticlesController@indexAuthor');

Route::get('articles/tag/{tagId}', 'ArticlesController@indexTags');

Route::get('home', 'HomeController@index');

Route::post('articles/imageSave', 'ArticlesController@imageSave');

Route::post('authors/imageSave', 'AuthorsController@imageSave');

Route::get('authors/imageEditor/{authorId}', 'AuthorsController@imageEditor');

Route::get('articles/imageEditor/{aritlceId}', 'ArticlesController@imageEditor');

Route::resource('articles', 'ArticlesController');

Route::resource('authors', 'AuthorsController');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);


