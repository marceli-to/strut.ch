<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->group(function () {
    Route::get('dashboard', function () {
        return response()->json(['data' => 'Test Data']);
    });

    // Post routes
    Route::get('posts', 'PostController@index');
    Route::post('post/create', 'PostController@store');
    Route::get('post/edit/{id}', 'PostController@edit');
    Route::post('post/update/{id}', 'PostController@update');
    Route::get('post/status/{id}', 'PostController@status');
    Route::delete('post/delete/{id}', 'PostController@delete');
    Route::post('post/order', 'PostController@order');

    // Grid routes
    Route::get('grid', 'Backend\Grid\GridController@index');
    Route::get('grid/store/{layoutId}', 'Backend\Grid\GridController@store');
    Route::delete('grid/delete/{id}', 'Backend\Grid\GridController@destroy');

    Route::get('gridlayout/fetch', 'Backend\Grid\GridLayoutController@fetch');

    // Media routes
    Route::post('media/upload','MediaController@upload');

    // PostMedia routes
    Route::delete('postmedia/delete/{file}', 'PostMediaController@delete');
});

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});



