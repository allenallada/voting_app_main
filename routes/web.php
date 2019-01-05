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
});
Route::get('/admin', 'AdminsController@home');

Route::get('/admin/register', 'AdminsController@register');

Route::post('/admin/login', 'AdminsController@login');

Route::post('/admin/create', 'AdminsController@create');
