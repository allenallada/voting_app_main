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
	Route::delete('/admin/partylist/{partylist}', 'PartylistController@delete');
});

