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
  Route::get('/', function() {
    return redirect('/admin/dashboard');
  })->middleware('verified');
  Route::resource('/users', 'UsersController', ['except' => ['show', 'create', 'store']]);
  Route::resource('/droids', 'DroidsController', ['except' => ['show', 'store']]);
  Route::resource('/events', 'EventsController', ['except' => ['show']]);
  Route::resource('/achievements', 'AchievementsController', ['except' => ['show']]);
  Route::resource('/clubs', 'ClubsController', ['except' => ['show']]);
  Route::resource('/locations', 'LocationController', ['except' => ['show']]);
  Route::resource('/dashboard', 'DashboardController', ['only' => ['index']]);
  Route::resource('/mot', 'MOTController', ['only' => ['create', 'store']]);
});

Route::get('/', function () {
    return view('home');
});

//Route::get('/', function() {
  //Route::get('user/id/{id}', 'UserController@id');
  Route::resource('user', 'UserController');
  Route::resource('droid', 'DroidController');
  Route::resource('mot', 'MOTController', ['only' => ['index', 'show']]);
  Route::get('mug_shot/{uid}', 'UserController@displayMugShot')->name('image.displayMugShot');
  Route::get('qr_code/{uid}', 'UserController@displayQRCode')->name('image.displayQRCode');
  Route::get('droid_image/{uid}/{view}', 'DroidController@displayDroidImage')->name('image.displayDroidImage');
  Route::resource('/events', 'EventController', ['only' => ['index', 'show', 'update']]);
//})->middleware('verified');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes(['verify' => true]);
