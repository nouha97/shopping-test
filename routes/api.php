<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


    Route::group(['prefix' => 'carts'], function(){
        Route::post('create', '\App\Http\Controllers\CartController@create');
        Route::get('/', '\App\Http\Controllers\CartController@index');
        Route::get('{id}', '\App\Http\Controllers\CartController@show');
        Route::put('{id}', '\App\Http\Controllers\CartController@update');
        Route::post('{id}/discount', '\App\Http\Controllers\CartController@discount');
        Route::delete('{id}', '\App\Http\Controllers\CartController@delete');
    });
    //test
    Route::group(['prefix' => 'products'], function(){
        Route::post('create', '\App\Http\Controllers\ProductController@create');

    });



