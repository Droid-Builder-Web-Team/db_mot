<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get(
    '/members',
    function (Request $request) {
        return $request->user();
    }
);

Route::group(
    ['middleware' => ['auth:api']],
    function () {
        Route::get('getmembers', 'Admin\ApiController@drivingCourseDownload');
        Route::get('getmemberimage/{uid}', 'Admin\ApiController@get_member_image');
        Route::get('getdroidimage/{uid}', 'Admin\ApiController@get_droid_image');
        Route::post('uploadrun', 'Admin\ApiController@upload_course_run');
    }
);
Route::get('events/future', 'EventApiController@getFutureAllPublicEvents');
Route::get('events/charity', 'EventApiController@getCharityYtd');
Route::get('events/charity/{year}', 'EventApiController@getCharityYtd');
Route::get('mot/{id}', 'MOTController@json');
