<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|/
*/




    Route::get('/', 'HomeController@index');
	Route::get('website', 'WebsiteController@index');
	Route::get('website/create', 'WebsiteController@create');
	Route::post('website/store', 'WebsiteController@store');
	Route::get('website/destroy/{id}', 'WebsiteController@destroy');
	Route::get('website/edit/{id}', 'WebsiteController@edit');
	Route::post('website/update/{id}', 'WebsiteController@update');
	Route::get('website/fields/{id}', 'WebsiteController@fields');
	Route::get('website/fieldedit/{id}', 'WebsiteController@fieldedit');
	Route::post('website/fieldupdate/{id}', 'WebsiteController@fieldupdate');
	Route::get('website/fielddestroy/{id}', 'WebsiteController@fielddestroy');
	Route::get('website/fieldcreate/{id}', 'WebsiteController@fieldcreate');
	Route::post('website/fieldstore/{id}', 'WebsiteController@fieldstore');
	Route::get('setup/domain/{id}','SetupController@domain');
	Route::get('setup/tag/{id}','SetupController@tag');
	Route::get('feeds/create/','FeedsController@create');
	Route::get('feeds','FeedsController@index');
	Route::post('feeds/getcategory', 'FeedsController@getcategory');
	Route::post('feeds/store', 'FeedsController@store');
	Route::get('feeds/destroy/{id}', 'FeedsController@destroy');
	Route::post('setup/storetag/{id}', 'SetupController@storetag');
	Route::get('feeds/readfeed/{id}', 'FeedsController@readfeed');
	Route::get('feeds/readall', 'FeedsController@readall');
	Route::get('feeds/single/{id}', 'FeedsController@single');
  Route::get('feeds/multi/{id}', 'FeedsController@multi');
	Route::get('feeds/edit/{id}', 'FeedsController@edit');
	Route::post('feeds/update/{id}', 'FeedsController@update');
	Route::get('post/', 'PostController@index');
	Route::post('post/publish/{id}', 'PostController@publish');
  Route::post('post/multi/', 'PostController@multi');

	Route::get('support/create', 'SupportController@create');
	Route::post('support/store', 'SupportController@store');

Route::get('setup/user','SetupController@user');
Route::get('post/test','PostController@test');

Route::post('setup/user','SetupController@createuser');
Route::get('login', [ 'as' => 'login', 'uses' => 'LoginController@index']);
Route::post('login', [ 'as' => 'login', 'uses' => 'LoginController@login']);
Route::get('error', [ 'as' => 'error', 'uses' => 'ErrorController@index']);
Route::get('team', [ 'as' => 'team', 'uses' => 'TeamController@index']);
Route::get('team/destroy/{id}', 'TeamController@destroy');
Route::get('team/edit/{id}', 'TeamController@edit');
	Route::post('team/update/{id}', 'TeamController@update');


Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::post('service/getdata', 'ServiceController@getdata');
Route::get('auth/login', 'Auth\AuthController@getLogin');
//////// mixer
Route::get('mixer/fieldadd', 'MixerController@fieldadd');
Route::post('mixer/getfields', 'MixerController@getfields');
Route::post('mixer/getfeeds', 'MixerController@getfeeds');
Route::post('mixer/fieldstore', 'MixerController@fieldstore');
Route::get('mixer/destroy/{id}', 'MixerController@destroy');
Route::get('mixer', 'MixerController@index');
Route::get('post/postlist', 'PostController@filterdomain');
Route::post('post/postlist', 'PostController@postlist');
Route::get('post/export/{id}', 'PostController@export');
Route::get('queue/readfeed/', 'QueueController@readfeed');
// crawler //
Route::get('crawler/extractdata/{id}', 'CrawlerController@extractdata');
Route::post('crawler/queuedata/{id}', 'CrawlerController@queuedata');
Route::get('crawler/tag/{id}', 'CrawlerController@tag');
Route::get('crawler/viewoutput', 'CrawlerController@viewoutput');
