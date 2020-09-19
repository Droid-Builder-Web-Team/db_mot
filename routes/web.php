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

//Auth::routes();
Auth::routes(['verify' => true]);
Auth::routes();

Route::redirect('/id.php', '/user');
Route::namespace('Admin')->prefix('admin')->name('admin.')->group(function() {
  Route::get('/', function() {
    return redirect('/admin/dashboard');
  });
  Route::resource('/users', 'UsersController', ['except' => ['show', 'create', 'store']]);
  Route::get('/droids/{id}', 'DroidsController@create')->name('droids.create');
  Route::put('droids/comment/{location}', 'DroidsController@comment')->name('droids.comment');
  Route::resource('/droids', 'DroidsController', ['except' => ['show', 'create']]);
  Route::resource('/events', 'EventsController', ['except' => ['show']]);
  Route::resource('/achievements', 'AchievementsController', ['except' => ['show']]);
  Route::resource('/clubs', 'ClubsController', ['except' => ['show']]);
  Route::resource('/locations', 'LocationController', ['except' => ['show']]);
  Route::resource('/dashboard', 'DashboardController', ['only' => ['index']]);
  Route::get('mot/{droid_id}', 'MOTController@create')->name('mot.create');
  Route::resource('/mot', 'MOTController', ['only' => ['store']]);
});

Route::get('/', function () {    return view('home');
});

Route::group(['middleware' => ['auth', 'gdpr.terms']], function() {
  Route::resource('user', 'UserController');
  Route::resource('droid', 'DroidController');
  Route::resource('mot', 'MOTController', ['only' => ['index', 'show']]);
  Route::get('mug_shot/{uid}/{size?}', 'UserController@displayMugShot')->name('image.displayMugShot');
  Route::get('qr_code/{uid}', 'UserController@displayQRCode')->name('image.displayQRCode');
  Route::get('droid_image/{uid}/{view}/{size?}', 'DroidController@displayDroidImage')->name('image.displayDroidImage');
  Route::put('event/comment/{event}', 'EventController@comment')->name('event.comment');
  Route::resource('event', 'EventController', ['only' => ['index', 'show', 'update']]);
  Route::put('location/comment/{location}', 'LocationController@comment')->name('location.comment');
  Route::resource('location', 'LocationController', ['only' => ['show']]);
  Route::get('image', 'ImageController@index')->name('image');
  Route::post('image/upload', 'ImageController@upload');
  Route::get('/cover_note/{id}', 'UserController@downloadPDF');
  Route::get('/info_sheet/{id}', 'DroidController@downloadPDF');
  Route::get('/id/{id}', 'ID');
  Route::get('/topps', 'ToppsController')->name('topps');
  Route::get('notifications', 'UserNotificationsController@show')->middleware('auth')->name('notifications');
  Route::resource('settings', 'UserSettingsController');
});


Route::get('change-password', 'ChangePasswordController@index');
Route::post('change-password', 'ChangePasswordController@store')->name('change.password');



Route::get('/home', 'HomeController@index')->name('home');
Route::post('ipn/notify','PaypalController@postNotify');
