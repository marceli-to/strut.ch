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

Route::get('media/thumbnail/{file}', 'MediaController@thumbnail');
Route::get('media/{file}/{size?}', 'MediaController@resize');

// Development Routes
Route::view('/', 'web.pages.index');


// Admin Routes
Route::view('admin', 'admin.app');
Route::get('admin/{any}', function () {
	return view('admin.app');
})->where('any', '.*');
