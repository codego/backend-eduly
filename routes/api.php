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

    Route::get('subject/{id}', 'SubjectController@show');
    Route::delete('subject/{id}', 'SubjectController@delete');
    Route::put('subject/{id}', 'SubjectController@edit');
    Route::post('subject', 'SubjectController@create');
    Route::get('subject', 'SubjectController@showAll');

    Route::get('career/{id}', 'CareerController@show');
    Route::delete('career/{id}', 'CareerController@destroy');
    Route::put('career/{id}', 'CareerController@edit');
    Route::post('career', 'CareerController@store');
    Route::get('career', 'CareerController@index');

    Route::get('course/{id}', 'CourseController@show');
    Route::delete('course/{id}', 'CourseController@destroy');
    Route::put('course/{id}', 'CourseController@update');
    Route::post('course', 'CourseController@store');
    Route::get('course', 'CourseController@index');

    Route::get('exam/{id}', 'ExamController@show');
    Route::delete('exam/{id}', 'ExamController@destroy');
    Route::put('exam/{id}', 'ExamController@update');
    Route::post('exam', 'ExamController@store');
    Route::get('exam', 'ExamController@index');


    Route::get('enroll/course/students', 'StudentAndCourseController@listStudentsInscribables');
    Route::get('enroll/course/enrolled-students', 'StudentAndCourseController@showFromCourse');
    Route::post('enroll/course/course', 'StudentAndCourseController@enroll');
    Route::delete('enroll/course/students/{id}', 'StudentAndCourseController@destroy');

    Route::get('correlatives', 'SubjectController@getCorrelatives');
    Route::get('subject_career', 'SubjectController@getCareers');

});

