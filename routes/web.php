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
Route::get('werkliste', 'Frontend\WorksController@byStatus')->name('page.works');
Route::get('werkliste/status', 'Frontend\WorksController@byStatus')->name('page.works.status');
Route::get('werkliste/jahr', 'Frontend\WorksController@byYear')->name('page.works.year');
Route::get('werkliste/typ', 'Frontend\WorksController@byType')->name('page.works.type');

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
Route::get('vortraege', 'Frontend\AboutController@lectures')->name('page.lectures');

// Home
Route::get('/', 'Frontend\HomeController@index')->name('page.home');


// PDF routes

// Concat 'Projektdokumentationen'
Route::get('/download/pdf/{id}/{slug?}', 'Frontend\PdfController@byCategory')->name('pdf.concat.category');

// Download 'Werklisten'
Route::get('/werkliste/pdf/gesamt', 'Frontend\PdfController@worksAll')->name('pdf.works.all');
Route::get('/werkliste/pdf/wohnen', 'Frontend\PdfController@worksLiving')->name('pdf.works.living');
Route::get('/werkliste/pdf/gewerbe', 'Frontend\PdfController@worksBusiness')->name('pdf.works.business');
Route::get('/werkliste/pdf/oeffentlich', 'Frontend\PdfController@worksPublic')->name('pdf.works.public');
Route::get('/werkliste/pdf/wettbewerb', 'Frontend\PdfController@worksCompetition')->name('pdf.works.competition');
Route::get('/werkliste/pdf/status', 'Frontend\PdfController@worksState')->name('pdf.works.state');
Route::get('/werkliste/pdf/jahr', 'Frontend\PdfController@worksYear')->name('pdf.works.year');
Route::get('/werkliste/pdf/typ', 'Frontend\PdfController@worksType')->name('pdf.works.type');

Route::get('404', ['as' => '404', 'uses' => 'Frontend\ErrorController@notfound']);
Route::get('500', ['as' => '500', 'uses' => 'Frontend\ErrorController@fatal']);

/**
 * Image routes
 */

Route::middleware('cache.headers:public;max_age=2628000;etag')->group(function() {
	Route::get('media/thumbnail/{file}', 'MediaController@thumbnail');
	Route::get('media/preview/{file}', 'MediaController@preview');
	Route::get('media/grid/{file}', 'MediaController@grid');
	Route::get('media/{file}/{size?}', 'MediaController@resize');
});


/**
 * Admin Routes
 */

Route::view('admin', 'admin.app');
Route::get('admin/{any}', function () {
	return view('admin.app');
})->where('any', '.*');


/**
 * Routes for artisan commands
 */
Route::get('/artisan/symlink', function () {
	Artisan::call('storage:link');
});

Route::get('/artisan/cache', function () {
	Artisan::call('cache:clear');
});

Route::get('/artisan/config', function () {
	Artisan::call('config:clear');
});

Route::get('/artisan/view', function () {
	Artisan::call('view:clear');
});

Route::get('/artisan/clearimages', function () {
	Artisan::call('images:clear');
});