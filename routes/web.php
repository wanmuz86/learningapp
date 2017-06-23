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


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('admin/courses/{id}/lessons/create', 'LessonController@createWithId');

Route::get('api/lesson/{id}', 'LessonController@getLesson');

Route::get('api/courses/', 'Api\CourseController@getAllCourse');

Route::post('api/coursesbyUser/', 'Api\CourseController@coursesbyUser');

Route::get('api/badges/', 'BadgeController@getAllBadge');

Route::post('api/badgesbyUser/', 'Api\BadgeController@badgesbyUser');

Route::get('api/quizbycourse/{id}', 'QuizController@getQuiz');


Route::post('api/coursebyuserold/', 'CourseController@coursesByUserold');

Route::post('api/purchasecourse/', 'Api\CourseController@purchaseCourse');
Route::post('api/usercatalog/', 'Api\CourseController@catalogByUser');

Route::post('api/updateLesson/', 'Api\LessonController@updateLesson');
Route::post('api/lessonByUser/', 'Api\LessonController@lessonByUser');

Route::post('api/login/', 'LoginController@login');
Route::post('api/getUser/', 'AuthenticateController@getUser');
Route::post('api/updateUser/', 'AuthenticateController@updateUser');

Route::group(['prefix' => 'api'], function()
{
    Route::resource('authenticate', 'AuthenticateController', ['only' => ['index']]);
    Route::post('authenticate', 'AuthenticateController@authenticate');
    Route::post('register', 'AuthenticateController@register');
});


