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
  Route::put('droids/comment/{droid}', 'DroidsController@comment')->name('droids.comment');
  Route::resource('/droids', 'DroidsController', ['except' => ['show', 'create']]);
  Route::get('events/delete_comment/{id}', 'EventsController@delete_comment')->name('events.delete_comment');
  Route::get('events/attendance/confirm/{event_id}/{user_id}', 'EventsController@confirm')->name('events.attendance.confirm');
  Route::get('events/attendance/deny/{event_id}/{user_id}', 'EventsController@deny')->name('events.attendance.deny');
  Route::resource('/events', 'EventsController', ['except' => ['show']]);
  Route::put('/achievements/award', 'AchievementsController@award')->name('achievements.award');
  Route::resource('/achievements', 'AchievementsController', ['except' => ['show']]);
  Route::resource('/clubs', 'ClubsController', ['except' => ['show']]);
  Route::resource('/locations', 'LocationController', ['except' => ['show']]);
  Route::resource('/dashboard', 'DashboardController', ['only' => ['index']]);
  Route::get('mot/{droid_id}', 'MOTController@create')->name('mot.create');
  Route::put('mot/comment/{mot}', 'MOTController@comment')->name('mot.comment');
  Route::resource('/mot', 'MOTController', ['only' => ['store']]);
  Route::get('audits', 'AuditController@index')->name('audits.index');
  Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->name('logs.index');
});

Route::get('/', function () {    return view('about');
});

Route::group(['middleware' => ['auth', 'gdpr.terms']], function() {
  Route::get('user/{user}/settings', 'UserController@edit_settings')->name('settings.edit');
  Route::put('user/{user}/settings', 'UserController@update_settings')->name('settings.update');
  Route::resource('user', 'UserController');
  Route::post('droid/togglePublic', 'DroidController@togglePublic')->name('droid.togglePublic');
  Route::resource('droid', 'DroidController');
  Route::get('database', 'DroidDatabase@index');
  Route::resource('mot', 'MOTController', ['only' => ['index', 'show']]);
  Route::resource('motinfo', 'MOTInfoController');
  Route::get('motinfo/{id}/export', 'MOTInfoController@exportMotInfo')->name('motinfo.export');
  Route::get('qr_code/{uid}', 'UserController@displayQRCode')->name('image.displayQRCode');
  Route::put('event/comment/{event}', 'EventController@comment')->name('event.comment');
  Route::put('location/comment/{location}', 'LocationController@comment')->name('location.comment');
  Route::resource('location', 'LocationController', ['only' => ['show']]);
  Route::post('/location/{location}/rating', 'LocationController@store')->name('location.rating');
  Route::get('image', 'ImageController@index')->name('image');
  Route::post('image/upload', 'ImageController@upload');
  Route::get('image/destroy', 'ImageController@destroy');
  Route::get('/cover_note/{id}', 'UserController@downloadPDF');
  Route::get('/info_sheet/{id}', 'DroidController@downloadPDF');
  Route::get('notifications', 'UserNotificationsController@index')->name('notifications');
  Route::get('notifications/read/{id}', 'UserNotificationsController@read')->name('notifications.read');
  Route::get('droid_image/{uid}/{view}/{size?}', 'DroidController@displayDroidImage')
              ->name('image.displayDroidImage');
  Route::get('mug_shot/{uid}/{size?}', 'UserController@displayMugShot')
              ->name('image.displayMugShot');
  Route::get('/images/update', 'ImageController@update');
  Route::resource('runs', 'CourseRunsController', ['only' => ['index', 'show']]);
  Route::resource('achievements', 'AchievementController');
  Route::get('change-password', 'ChangePasswordController@index');
  Route::post('change-password', 'ChangePasswordController@store')->name('change.password');
  Route::get('codeofconduct', 'CodeOfConductController@index')->name('codeofconduct');
  Route::post('codeofconduct', 'CodeOfConductController@store');
  Route::get('about', function() {
    return view('about');
  } )->name('about');

  // Parts Runs Extension
  Route::resource('/part-runs', 'PartsRunDataController');
  Route::get('/request-a-part-run', 'PartsRunDataController@requestPartsRun')->name('request');
  Route::get('/parts-run-info', function() {
    return view('part-runs.info');
  })->name('partsRunInfo');
});

Route::group(['middleware' => ['auth', 'gdpr.terms']], function() {
  Route::resource('event', 'EventController', ['only' => ['index', 'show', 'update']]);
});

Route::get('/id/{id}', 'ID');


Route::get('/auth/redirect/{provider}', 'SocialController@redirect');
Route::get('/callback/{provider}', 'SocialController@callback');

Route::get('/home', 'HomeController@index')->name('home');
Route::post('ipn/notify','PaypalController@postNotify');

Route::get('/topps', 'ToppsController@index')->name('topps');
Route::get('topps_image/{uid}/{view}/{size?}', 'ToppsController@displayToppsImage')
              ->name('image.displayToppsImage');
