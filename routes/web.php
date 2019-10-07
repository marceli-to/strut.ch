<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
*/

/**
 * Page routes
 */


// Bauten
Route::get('bauten', 'Frontend\ProjectsController@projects')->name('page.projects');
Route::get('bauten/vorschau/{project}', 'Frontend\ProjectsController@preview')->name('page.project-preview');
Route::get('bauten/{id}/{slug?}', 'Frontend\ProjectsController@project')->name('page.project-detail');

// Werkliste
Route::get('werkliste', 'Frontend\WorksController@index')->name('page.works');

// Publikationen
Route::get('presse', 'Frontend\PublicationsController@press')->name('page.press');
Route::get('buecher', 'Frontend\PublicationsController@books')->name('page.books');

// Publikationen - Downloads
Route::get('downloads', 'Frontend\DownloadsController@index')->name('page.downloads');

// Kontakt
Route::get('kontakt', 'Frontend\ContactController@index')->name('page.contact');

// Büro
Route::get('ueber-uns', 'Frontend\AboutController@about')->name('page.about');
Route::get('jobs', 'Frontend\AboutController@jobs')->name('page.jobs');
Route::get('auszeichnungen', 'Frontend\AboutController@awards')->name('page.awards');
Route::get('votraege', 'Frontend\AboutController@lectures')->name('page.lectures');

// Home
Route::get('/', 'Frontend\HomeController@index')->name('page.home');


/**
 * Image routes
 */

Route::middleware('cache.headers:public;max_age=2628000;etag')->group(function() {
	Route::get('media/thumbnail/{file}', 'MediaController@thumbnail');
	Route::get('media/preview/{file}', 'MediaController@preview');
	Route::get('media/{file}/{size?}', 'MediaController@resize');
});



/**
 * Admin Routes
 */

Route::view('admin', 'admin.app');
Route::get('admin/{any}', function () {
	return view('admin.app');
})->where('any', '.*');
