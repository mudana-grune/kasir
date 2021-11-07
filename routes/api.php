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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('auth')->group(function () {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::get('refresh', 'AuthController@refresh');

    Route::group(['middleware' => 'auth:api'], function(){
        Route::get('user', 'AuthController@user');
        Route::post('logout', 'AuthController@logout');
    });
});

Route::group(['middleware' => 'auth:api'], function(){
    // Users
    Route::group(['middleware'=>'isAdmin'], function(){
        Route::get('users', 'UserController@index');
        Route::post('users/{id}','UserController@update');
        Route::post('users','UserController@store');
        Route::get('users/check', 'UserController@checkUsername');
        Route::delete('users/{id}', 'UserController@destroy');
    });
    Route::group(['middleware'=>'isManager'], function(){
        Route::get('cabang', 'CabangController@index');
        Route::post('cabang', 'CabangController@store');
        Route::post('cabang/{id}', 'CabangController@update');
        Route::delete('cabang/{id}', 'CabangController@destroy');
    });

    Route::get('users/{id}', 'UserController@show')->middleware('isAdminOrSelf');
});
