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
        Route::get('/new', 'PostController@new')->name('new');
        Route::post('/new', 'PostController@create')->name('create');
        
        Route::middleware('can:performAction,post')->prefix('/{post}')->group(function () {
            Route::get('/', 'PostController@detail')->name('detail');
            Route::get('/edit', 'PostController@edit')->name('edit');
            Route::post('/edit', 'PostController@update')->name('update');
            Route::delete('/delete', 'PostController@delete')->name('delete');
        });
    });

    Route::prefix('/users')->name('users.')->group(function () {
        Route::get('/', 'UserController@index')
            ->middleware('can:viewList,App\User')
            ->name('index');
        Route::get('/new', 'UserController@new')
            ->middleware('can:create,App\User')
            ->name('new');
        Route::post('/new', 'UserController@store')
            ->middleware('can:create,App\User')
            ->name('store');
        Route::get('/{user}', 'UserController@show')
            ->middleware('can:view,user')
            ->name('show');
        Route::get('/{user}/edit', 'UserController@edit')
            ->middleware('can:update,user')
            ->name('edit');
        Route::put('/{user}/edit', 'UserController@update')
            ->middleware('can:update,user')
            ->name('update');
        Route::delete('/{user}/delete', 'UserController@delete')
            ->middleware('can:delete,user')
            ->name('delete');
    });

    Route::prefix('/supervisors')->name('supervisors.')->group(function () {
        Route::get('/', 'SupervisorController@index')
            ->middleware('can:viewSupervisor,App\User')
            ->name('index');
        Route::get('/{user}/bloggers', 'SupervisorController@bloggers')
            ->middleware('can:viewSupervisor,App\User')
            ->name('bloggers');
    });
});