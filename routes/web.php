<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;

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
    
    
    return Redirect::to('https://fabtransport.com.au');

    // return view('welcome');
});


Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('optimize');

  return 'done';
});




Route::get('/link-file', function () {

    File::link(storage_path('app/public'), public_path('storage'));

  return 'done';
});

Route::get('admin/duplicate/{product}', 'App\Http\Controllers\ProductDuplicationController@duplicate')->name('voyager.products.duplicate');
 Route::get('new-submissions', 'App\Http\Controllers\Api\V1\ContactController@checkNewSubmissions');
// Route::post('/products', 'ProductController@store');

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});




