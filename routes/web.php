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

// Werkliste
Route::get('werkliste', 'Frontend\ContactController@index')->name('page.works');

// Publikationen
Route::get('presse', 'Frontend\PublicationsController@press')->name('page.press');
Route::get('buecher', 'Frontend\PublicationsController@books')->name('page.books');
Route::get('downloads', 'Frontend\PublicationsController@downloads')->name('page.downloads');

// Kontakt
Route::get('kontakt', 'Frontend\ContactController@index')->name('page.contact');

// Büro
Route::get('ueber-uns', 'Frontend\AboutController@about')->name('page.about');
Route::get('jobs', 'Frontend\AboutController@jobs')->name('page.jobs');
Route::get('auszeichnungen', 'Frontend\AboutController@awards')->name('page.awards');
Route::get('votraege', 'Frontend\AboutController@lectures')->name('page.lectures');

/**
 * Image routes
 */

Route::get('media/thumbnail/{file}', 'MediaController@thumbnail');
Route::get('media/{file}/{size?}', 'MediaController@resize');


/**
 * Development Routes
 */

Route::view('/', 'web.pages.home');
//Route::view('/ueber-uns', 'web.pages.about-us');

/**
 * Admin Routes
 */

Route::view('admin', 'admin.app');
Route::get('admin/{any}', function () {
	return view('admin.app');
})->where('any', '.*');
