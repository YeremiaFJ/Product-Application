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

Route::get('/', 'ProductController@index');
Route::get('/new-products', 'ProductController@new');


Route::post('/', 'ProductController@create');
Route::get('/show', 'ProductController@show');
Route::patch('/edit/{id}', 'ProductController@update');
Route::delete('/delete/{id}', 'ProductController@destroy');
Route::get('/imgSrc', 'ProductController@getImgSrc');

Route::get('/retrieve_session', 'UserController@retrieveSession');
Route::get('/retrieve_api', 'UserController@retrieveAPI');
Route::get('/get_user', 'UserController@getUser');
Route::get('/callback', 'UserController@callback');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/profile', 'UserController@profile');
Route::post('/edit_profile', 'UserController@editProfile');
