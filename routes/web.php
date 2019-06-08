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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::post('/submit', 'PostController@store')->name('submit');
Route::get('/post/{id}', 'PostController@show')->name('show');

Route::post('/settings/update', 'ProfileController@update')->name('settings');
Route::get('/profile/{username}', 'ProfileController@show')->name('profile');
Route::get('/post/upvote/{id}', 'VoteController@upvote')->name('upvote');
Route::get('/post/downvote/{id}', 'VoteController@downvote')->name('downvote');
Route::post('/comment/submit', 'CommentController@create')->name('comment');