<?php

/**
 * Routes for web gate
 * php version 7.4
 *
 * @category Routes
 * @package  Web
 * @author   Darren Poulson <darren.poulson@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */

use App\VenueContact;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PayPalController;
use App\Http\Controllers\BallotController;
use Laravel\Fortify\RouteServiceProvider;

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
Auth::routes(['verify' => true, 'login' => false, 'twofactor' => false]);
//Auth::routes();


Route::redirect('/id.php', '/user');
Route::namespace('Admin')->prefix('admin')->name('admin.')->group(
    function () {
        Route::get(
            '/',
            function () {
                return redirect('/admin/dashboard');
            }
        );
        Route::resource('/users', 'UsersController', ['except' => ['show', 'create', 'store']]);
        Route::get('/droids/{id}', 'DroidsController@create')->name('droids.create');
        Route::resource('/droids', 'DroidsController', ['except' => ['show', 'create']]);
        Route::get('events/attendance/confirm/{event_id}/{user_id}', 'EventsController@confirm')->name('events.attendance.confirm');
        Route::get('events/attendance/deny/{event_id}/{user_id}', 'EventsController@deny')->name('events.attendance.deny');
        Route::get('events/image/{event_id}', 'EventsController@addimage')->name('events.addimage');
        Route::post('events/image', 'EventsController@storeimage')->name('events.storeimage');
        Route::get('events/export/{id}', 'EventsController@export')->name('events.export');
        Route::resource('/events', 'EventsController', ['except' => ['show']]);
        Route::put('/achievements/award', 'AchievementsController@award')->name('achievements.award');
        Route::resource('/achievements', 'AchievementsController', ['except' => ['show']]);
        Route::resource('/clubs', 'ClubsController', ['except' => ['show']]);
        Route::resource('/locations', 'LocationController', ['except' => ['show']]);
        Route::resource('/dashboard', 'DashboardController', ['only' => ['index']]);
        Route::get('mot/{droid_id}', 'MOTController@create')->name('mot.create');
        Route::resource('/mot', 'MOTController', ['only' => ['store']]);
        Route::resource('/motdesign', 'MOTDesignController', ['only' => ['edit', 'update']]);
        Route::get('audits', 'AuditController@index')->name('audits.index');
        Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->name('logs.index');
        Route::resource('/contacts', 'ContactController');
        Route::post('/contacts/link', 'ContactController@link')->name('contacts.link');
        Route::post('/contacts/unlink', 'ContactController@unlink')->name('contacts.unlink');
        Route::get('/api/bcreps/{club_id}', 'ApiController@list_bcreps');
        Route::get('/stats', 'StatsController@index');
        Route::get('/api/stats/{stat}', 'StatsController@getStat');
        Route::resource('/map', 'MapsController', ['only' => ['index']]);
        Route::get('/badges/{keep}', 'BadgeController@download')->name('badges.download');
        Route::get('/ballots', [BallotController::class, 'index'])->name('ballots.index');
        Route::get('/ballots/create', [BallotController::class, 'create'])->name('ballots.create');
        Route::post('/ballots', [BallotController::class, 'store'])->name('ballots.store');
        Route::delete('/ballots/{ballot}', [BallotController::class, 'destroy'])->name('ballots.destroy');
    }
);

Route::get(
    '/',
    function () {
        return view('about');
    }
);

Route::group(
    ['middleware' => ['auth', 'gdpr.terms']],
    function () {
        Route::get('user/{user}/settings', 'UserController@edit_settings')->name('settings.edit');
        Route::put('user/{user}/settings', 'UserController@update_settings')->name('settings.update');
        Route::resource('user', 'UserController');
        Route::post('droid/togglePublic', 'DroidController@togglePublic')->name('droid.togglePublic');
        Route::resource('droid', 'DroidController');
        Route::resource('database', 'DroidDatabase');
        Route::resource('mot', 'MOTController', ['only' => ['index', 'show']]);
        Route::resource('portalnews', 'PortalNewsController');
        Route::resource('assistance', 'AssistanceController');
        Route::resource('motinfo', 'MOTInfoController');
        Route::resource('asset', 'AssetController');
        Route::resource('nominations', 'NominationController');
        Route::get('motinfo/{id}/export', 'MOTInfoController@exportMotInfo')->name('motinfo.export');
        Route::get('motinfo/{id}/test', 'MOTInfoController@exportMotTest')->name('motinfo.test');
        Route::get('qr_code/{uid}', 'UserController@displayQRCode')->name('image.displayQRCode');
        Route::get('event/past', 'EventController@past')->name('event.past');
        Route::get('event/map', 'EventController@map')->name('event.map');
        Route::resource('location', 'LocationController', ['only' => ['show', 'create', 'store']]);
        Route::post('/location/{location}/rating', 'LocationController@rating')->name('location.rating');
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
        Route::post('comments/{id}', 'CommentController@store')->name('comment.add');
        Route::get('comments/{id}', 'CommentController@delete')->name('comment.delete');
        Route::post('/reaction', 'CommentController@fetchReactions');
        Route::post('/reaction/{id}', 'CommentController@handleReaction');
        Route::get('change-password', 'ChangePasswordController@index');
        Route::post('change-password', 'ChangePasswordController@store')->name('change.password');
        Route::get('codeofconduct', 'CodeOfConductController@index')->name('codeofconduct');
        Route::post('codeofconduct', 'CodeOfConductController@store');
        Route::get(
            'about',
            function () {
                return view('about');
            }
        )->name('about');

        // Parts Runs Extension

        Route::resource('/parts-run', 'PartsRunDataController');
        Route::get('parts-run/image/{run_id}/{number?}/{size?}', 'PartsRunImageController@show')
            ->name('image.displayPartsRunImage');
        Route::get('/request-a-part-run', 'PartsRunDataController@requestPartsRun')
            ->name('request');
        Route::get(
            '/parts-run-info',
            function () {
                return view('parts-run.info');
            }
        )->name('partsRunInfo');
        Route::put('parts-run/comment/{partsrun}', 'PartsRunDataController@comment')->name('parts-run.comment');
        Route::get('parts-run/interested/{partsrun}', 'PartsRunDataController@interested')->name('parts-run.interested');
        Route::post('parts-run/status_update', 'PartsRunDataController@statusUpdate')->name('parts-run.status_update');
        Route::get('parts-run/export/{partsrun}', 'PartsRunDataController@export')->name('parts-run.export');


        Route::resource('auctions', 'AuctionController');
        Route::resource('ware', 'WareController');
        Route::put('auctions/bid/{auction}', 'AuctionController@bid')->name('auctions.bid');

        Route::get('language/{locale}', function ($locale) {
            app()->setLocale($locale);
            session()->put('locale', $locale);
            return redirect()->back();
        });
        Route::get('/ballots/{ballot}', [BallotController::class, 'show'])->name('ballots.show');
        Route::post('/ballots/{ballot}/vote', [BallotController::class, 'vote'])->name('ballots.vote');
        Route::get('/ballots/{ballot}/results', [BallotController::class, 'results'])->name('ballots.results');
        Route::get('/ballots', [BallotController::class, 'index'])->name('ballots.index');
    }
);


Route::group(
    ['middleware' => ['auth', 'gdpr.terms']],
    function () {
        Route::resource('event', 'EventController', ['only' => ['index', 'show', 'create', 'store', 'update']]);
    }
);

Route::get('/id/{id}', 'ID');
Route::get('/ical/{icalId}/{scope?}', 'ICalController');


Route::get('/auth/redirect/{provider}', 'SocialController@redirect');
Route::get('/callback/{provider}', 'SocialController@callback');

Route::get('/home', 'HomeController@index')->name('home');
# Route::post('ipn/notify', 'PaypalController@postNotify');

Route::get('/topps', 'ToppsController@index')->name('topps');
Route::get('topps_image/{uid}/{view}/{size?}', 'ToppsController@displayToppsImage')
    ->name('image.displayToppsImage');
Route::get('events/image/show/{event_id}', 'EventApiController@showimage')
    ->name('events.showimage');

    
Route::get('/chart', 'QrCodeController@show')->name('chart');

Route::get('create-transaction', [PayPalController::class, 'createTransaction'])->name('createTransaction');
Route::get('process-transaction', [PayPalController::class, 'payPLI'])->name('payPLI');
Route::get('success-transaction', [PayPalController::class, 'successTransaction'])->name('successTransaction');
Route::get('cancel-transaction', [PayPalController::class, 'cancelTransaction'])->name('cancelTransaction');
