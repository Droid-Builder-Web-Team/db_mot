<?php

use Illuminate\Support\Facades\Route;

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

Route::namespace('Admin')->prefix('admin')->name('admin.')->group(function() {
  Route::resource('/users', 'UsersController', ['except' => ['show', 'create', 'store']]);
  Route::resource('/droids', 'DroidsController', ['except' => ['show', 'store']]);
  Route::resource('/events', 'EventsController', ['except' => ['show', 'store']]);
  Route::resource('/achievements', 'AchievementsController', ['except' => ['show', 'store']]);
});

Route::get('/', function () {
    return view('home');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');