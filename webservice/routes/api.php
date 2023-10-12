<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route; // Importe a classe Route corretamente

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

Route::middleware(['api'])->group(function () {
        Route::get('index', 'UserController@index');
        Route::post('user/store', 'UserController@store');
        Route::get('user/edit/{id}', 'UserController@edit');
        Route::put('usersupdate/{id}', 'UserController@update');
        Route::delete('user/destroy/{id}', 'UserController@destroy');


        Route::get('book/index', 'BookController@index');
        Route::post('book/store', 'BookController@store');
        Route::get('book/edit/{id}', 'BookController@edit');
        Route::put('book/update/{id}', 'BookController@update');
        Route::delete('book/destroy/{id}', 'BookController@destroy');


        Route::get('rent/index', 'RentController@index');
        Route::post('rent/store', 'RentController@store');
        Route::get('rent/edit/{id}', 'RentController@edit');
        Route::put('rent/update/{id}', 'RentController@update');
        Route::delete('rent/destroy/{id}', 'RentController@destroy');
        Route::get('rent/export-rents-to-txt', 'RentController@exportRentsToTxt');

});

