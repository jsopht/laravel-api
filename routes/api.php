<?php

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

Route::get('/sheet-file-process/status', 'SheetFileProcessController@status')->name('sheet_file_process.status');
Route::resource('/products', 'ProductController')->except('edit');
