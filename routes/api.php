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
    Route::get('posts/get', 'PostController@get');
    Route::get('posts/grid', 'PostController@grid');
    Route::post('post/create', 'PostController@store');
    Route::get('post/edit/{id}', 'PostController@edit');
    Route::post('post/update/{id}', 'PostController@update');
    Route::get('post/status/{id}', 'PostController@status');
    Route::delete('post/delete/{id}', 'PostController@delete');
    Route::post('post/order', 'PostController@order');

    // News routes
    Route::post('news/create', 'Backend\NewsController@store');

    // Grid routes
    Route::get('grid', 'Backend\Grid\GridController@index');
    Route::get('grid/store/{layoutId}', 'Backend\Grid\GridController@store');
    Route::delete('grid/delete/{id}', 'Backend\Grid\GridController@destroy');

    // Get all grid layouts
    Route::get('gridlayout/fetch', 'Backend\Grid\GridLayoutController@fetch');

    // Insert a new grid element
    Route::post('gridelement/store', 'Backend\Grid\GridElementController@store');

    // Delete a grid element
    Route::delete('gridelement/delete/{id}', 'Backend\Grid\GridElementController@destroy');
    Route::get('gridelement/get/{id}', 'Backend\Grid\GridElementController@get');

    // Media routes
    Route::post('media/upload','MediaController@upload');
    Route::get('media/{file}/{size?}', 'MediaController@resize');

    // PostMedia routes
    Route::delete('postmedia/delete/{file}', 'PostMediaController@delete');
});

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});



