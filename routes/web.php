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

Route::get('/', 'TreeManagerController@index');
Route::post('/add', 'TreeManagerController@addNode');
Route::get('/tree', 'TreeManagerController@getNodes');
Route::post('/delete', 'TreeManagerController@deleteNode');