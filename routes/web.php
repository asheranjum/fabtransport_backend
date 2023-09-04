<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

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


Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');

  return 'done';
});


Route::get('/link-file', function () {

    File::link(storage_path('app/public'), public_path('storage'));

  return 'done';
});

Route::get('admin/duplicate/{product}', 'App\Http\Controllers\ProductDuplicationController@duplicate')->name('voyager.products.duplicate');

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});




