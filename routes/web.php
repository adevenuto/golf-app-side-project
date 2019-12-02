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
Route::get('/profile', 'ProfileController@index')->name('profile')->middleware('auth');
Route::get('/auth/user', 'ProfileController@authUser')->name('profile.auth.user')->middleware('auth');
Route::post('/store', 'ProfileController@store')->name('profile.store')->middleware('auth');
