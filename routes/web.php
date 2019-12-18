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

Route::get('/', function () {
    return view('welcome');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/posts', 'PostController@store')->name('posts.store');
Route::get('/user/{user}', 'UsersController@show')->name('user.show');
Route::post('/user/{user}/follow', 'UsersController@follow')->name('user.follow');
Route::delete('/user/{user}/unfollow', 'UsersController@unfollow')->name('user.unfollow');


Route::get('/user/notification-mark-as-read/{id}', 'UsersController@markasRead')->name('markasRead');
Route::get('/users/all-notifications/{id}', 'UsersController@allNotifications');