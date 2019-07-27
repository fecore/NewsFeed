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

//Route::get('/', 'IndexController@index');
Route::get('/', function () {
    return 2;
});

// News resource
//Route::resource('');



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
    Route::resource('/news', 'NewsController');
}
);

Auth::routes();



Route::get('/home', 'HomeController@index')->name('home');
