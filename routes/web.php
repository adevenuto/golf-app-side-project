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
    return view('landing');
});

Auth::routes();


Route::get('/dashboard', 'DashboardController@index')->name('dashboard')->middleware('auth');
// Profile Controller
Route::get('/profile', 'ProfileController@index')->name('profile')->middleware('auth');
Route::post('/profile/store', 'ProfileController@store')->name('profile.store')->middleware('auth');

// Courses controller
Route::get('/courses', 'CourseController@index');

Route::get('/courses/search', 'CourseController@search');
Route::get('/course/teeboxes/{id}', 'CourseController@getTeeboxes');
Route::get('/course/{course_id}/holegroups/{teebox}', 'CourseController@getHolegroups');

Route::get('/course/create', 'CourseController@create')->middleware('auth');
Route::post('/course/store', 'CourseController@store')->middleware('auth');
Route::get('/course/edit/{id}', 'CourseController@edit')->middleware('auth');
Route::post('/course/update', 'CourseController@update')->middleware('auth');

// HoleGroup Controller
Route::post('/course/holegroup/create', 'HoleGroupController@store')->middleware('auth');
Route::get('/course/holegroup/edit/{id}', 'HoleGroupController@edit')->middleware('auth');
Route::post('/course/holegroup/update', 'HoleGroupController@update')->middleware('auth');

// Favorites controller
Route::post('/course/favorite/{id}', 'FavoriteController@favoriteCourse')->middleware('auth');
Route::post('/course/unfavorite/{id}', 'FavoriteController@unFavoriteCourse')->middleware('auth');

// Games controller
Route::get('/game/create', 'GameController@create')->middleware('auth');
Route::post('/game/store', 'GameController@store')->middleware('auth');
Route::get('/game/{uuid}', 'GameController@show')->middleware('auth');

