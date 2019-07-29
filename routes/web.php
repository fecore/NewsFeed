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

use App\Category;

Route::get('/',                     'IndexController@index')->name('index');
Route::get('/category/{category}',  'IndexController@category')->name('category');
Route::get('/article/{feedEntity}', 'IndexController@show')->name ('article');


Route::get('/config-clear', function() {
    $exitCode = Artisan::call('cache:clear');
    // return what you want
});

Route::get('/config-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    // return what you want
});

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
