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

Route::get('/', 'IndexController@index');



// Admin panel
Route::group
(
    [
        'namespace' => 'Admin',
        'prefix' => 'admin',
        'middleware' => 'auth',
    ]
    , function()
    {

        Route::get('/', 'DashboardController@index')->name('dashboard');
        // News resource
        Route::resource('/news', 'NewsController', ['parameters' => [
            'news' => 'newsItem'
        ]]);
    }
);

Auth::routes();
