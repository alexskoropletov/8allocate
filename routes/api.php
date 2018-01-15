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


Route::put('/customer', 'CustomerController@add')->middleware('api.token', 'api.log');

Route::get('/transaction/{customerId}/{transactionId}', 'TransactionController@show')->middleware('api.token', 'api.log');
Route::get('/transaction/{customerId?}/{amount?}/{date?}/{offset?}/{limit?}', 'TransactionController@filter')
    ->middleware('api.token', 'api.log');
Route::put('/transaction', 'TransactionController@add')->middleware('api.token', 'api.log');
Route::post('/transaction', 'TransactionController@update')->middleware('api.token', 'api.log');
Route::delete('/transaction/{id}', 'TransactionController@destroy')->middleware('api.token', 'api.log');