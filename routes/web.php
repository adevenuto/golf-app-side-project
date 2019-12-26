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
Route::get('/course/create', 'CourseController@create')->middleware('auth');
Route::post('/course/store', 'CourseController@store')->middleware('auth');
Route::get('/course/edit/{id}', 'CourseController@edit')->middleware('auth');
Route::post('/course/update/', 'CourseController@update')->middleware('auth');

// Favorites controller
Route::post('/course/favorite/{id}', 'FavoriteController@favoriteCourse')->middleware('auth');
Route::post('/course/unfavorite/{id}', 'FavoriteController@unFavoriteCourse')->middleware('auth');
