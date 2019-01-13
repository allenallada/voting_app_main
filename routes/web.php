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

Route::get('/', function () {
    return view('welcome');
})->middleware('has_session');

Route::post('/admin/login', 'AdminsController@login');
Route::get('/admin/register', 'AdminsController@register');
Route::post('/admin/create', 'AdminsController@create');

Route::group(['middleware' => ['is_logged_in']], function () {
    Route::get('/admin', 'AdminsController@home');
	Route::get('/admin/logout', 'AdminsController@logout');
	Route::get('/admin/candidates', 'CandidateController@index');
	Route::delete('/admin/candidates/{candidate}', 'CandidateController@delete');
	Route::post('/admin/candidates/store', 'CandidateController@store');
	Route::post('/admin/partylist/store', 'PartylistController@store');
	Route::post('/admin/{admin}/update', 'AdminsController@update');
	Route::post('/admin/{admin}/delete', 'AdminsController@delete');
	Route::delete('/admin/partylist/{partylist}', 'PartylistController@delete');
	Route::get('/admin/voters', 'VotersController@index');
	Route::get('/admin/export/summary', 'AdminsController@exportResult');
	Route::get('/admin/export/voter', 'AdminsController@exportVoters');
});


Route::get('/api/mobile/getCandidates', 'CandidateController@getCandidates');

Route::group(['middleware' => ['app_key_verify']], function () {
	Route::post('/api/local/register', 'VotersController@store');
	Route::post('/api/local/login', 'AdminsController@apiLogin');
	Route::post('/api/mobile/login', 'VotersController@login');
	Route::post('/api/mobile/vote', 'VotersController@vote');
	
 	// Route::get('/admin', 'AdminsController@home');
	// Route::get('/admin/logout', 'AdminsController@logout');
	// Route::get('/admin/candidates', 'CandidateController@index');
	// Route::delete('/admin/candidates/{candidate}', 'CandidateController@delete');
	// Route::post('/admin/candidates/store', 'CandidateController@store');
	// Route::post('/admin/partylist/store', 'PartylistController@store');
	// Route::delete('/admin/partylist/{partylist}', 'PartylistController@delete');
	// Route::get('/admin/voters', 'VotersController@index');
});

// app_key_verify

