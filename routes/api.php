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

Route::post('register', 'AuthController@register');
Route::post('login', 'AuthController@login');
Route::post('recover', 'AuthController@recover');
Route::group(['middleware' => ['jwt.auth']], function() {
    Route::get('logout', 'AuthController@logout');

    Route::get('students/{id}', 'StudentsController@show');
    Route::delete('students/{id}', 'StudentsController@delete');
    Route::put('students/{id}', 'StudentsController@edit');
    Route::post('students', 'StudentsController@create');
    Route::get('students', 'StudentsController@showAll');

    Route::get('teachers/{id}', 'TeachersController@show');
    Route::delete('teachers/{id}', 'TeachersController@delete');
    Route::put('teachers/{id}', 'TeachersController@edit');
    Route::post('teachers', 'TeachersController@create');
    Route::get('teachers', 'TeachersController@showAll');

});

