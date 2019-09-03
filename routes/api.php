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

Route::middleware('auth:api')->group(function() {
    
    // Route::get('dashboard', function() {
    //     return response()->json(['data' => 'Test Data']);
    // });

    // Post routes
    Route::get('posts/get', 'PostController@get');
    Route::get('posts/grid', 'PostController@grid');
    Route::post('post/create', 'PostController@store');
    Route::get('post/edit/{id}', 'PostController@edit');
    Route::post('post/update/{id}', 'PostController@update');
    Route::get('post/status/{id}', 'PostController@status');
    Route::delete('post/delete/{id}', 'PostController@delete');
    Route::post('post/order', 'PostController@order');

    // PostMedia routes
    Route::delete('postmedia/delete/{file}', 'PostMediaController@delete');

    // Job routes
    Route::get('jobs/get', 'Backend\Job\JobController@get');
    Route::post('job/create', 'Backend\Job\JobController@store');
    Route::get('job/edit/{id}', 'Backend\Job\JobController@edit');
    Route::post('job/update/{id}', 'Backend\Job\JobController@update');
    Route::get('job/clone/{id}', 'Backend\Job\JobController@clone');
    Route::get('job/status/{id}', 'Backend\Job\JobController@status');
    Route::delete('job/destroy/{id}', 'Backend\Job\JobController@destroy');
    Route::post('job/order', 'Backend\Job\JobController@order');
    Route::delete('job/delete/file/{file}', 'Backend\Job\JobController@unlink');

    // Team routes
    Route::get('team/get', 'Backend\Team\TeamController@get');
    Route::post('team/create', 'Backend\Team\TeamController@store');
    Route::get('team/edit/{id}', 'Backend\Team\TeamController@edit');
    Route::post('team/update/{id}', 'Backend\Team\TeamController@update');
    Route::get('team/clone/{id}', 'Backend\Team\TeamController@clone');
    Route::get('team/status/{id}', 'Backend\Team\TeamController@status');
    Route::delete('team/destroy/{id}', 'Backend\Team\TeamController@destroy');
    Route::post('team/order', 'Backend\Team\TeamController@order');
    Route::delete('team/delete/file/{file}', 'Backend\Team\TeamController@unlink');

    // Book routes
    Route::get('books/get', 'Backend\Book\BookController@get');
    Route::post('book/create', 'Backend\Book\BookController@store');
    Route::get('book/edit/{id}', 'Backend\Book\BookController@edit');
    Route::post('book/update/{id}', 'Backend\Book\BookController@update');
    Route::get('book/clone/{id}', 'Backend\Book\BookController@clone');
    Route::get('book/status/{id}', 'Backend\Book\BookController@status');
    Route::delete('book/destroy/{id}', 'Backend\Book\BookController@destroy');
    Route::post('book/order', 'Backend\Book\BookController@order');
    Route::delete('book/delete/file/{file}', 'Backend\Book\BookController@unlink');

    // News routes
    Route::post('news/create', 'Backend\NewsController@store');
    Route::post('news/delete/{id}', 'Backend\NewsController@destroy');

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
    Route::post('media/upload/document','MediaController@uploadDocument');
    Route::get('media/{file}/{size?}', 'MediaController@resize');

});

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});



