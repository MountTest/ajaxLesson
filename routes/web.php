<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/','EmployeeController@main');
Route::post('/search', 'EmployeeController@search')->name('search');


Route::post('/filter', 'EmployeeController@filter')->name('filter');

Route::post('/status', 'EmployeeController@status')->name('status');

Route::put('/inversion_status', 'EmployeeController@inversion_status')->name('inversion_status');