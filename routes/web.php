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

Route::middleware('auth')->name('app.')->group(function () {
    // Account Routes
    Route::prefix('/account')->name('account.')->group(function () {
        Route::post('/update', 'AccountController@update')->name('update');
    });

    Route::prefix('/posts')->name('posts.')->group(function () {
        Route::get('/', 'PostController@index')->name('index');
    });
});