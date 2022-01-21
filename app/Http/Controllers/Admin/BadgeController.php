<?php

/**
 * ID Badge Controller
 * php version 7.4
 *
 * @category Controller
 * @package  Controllers
 * @author   Darren Poulson <darren.poulson@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use Illuminate\Support\Facades\DB;
use App\User;

/**
 * ID Badge Controller
 *
 * @category Class
 * @package  Controllers
 * @author   Darren Poulson <darren.poulson@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */
class BadgeController extends Controller
{
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:View Members');

    }

    /**
     * Download the zip of ID badge details
     *
     * @param bool $clear Clear the ID Badge table
     *
     * @return void
     */
    public function download($clear)
    {
        $badges = DB::table('id_list')
            ->where('paid', true)->get();

        $zip = new ZipArchive();
        $zip_file = "/storage/test.zip";
        $zip->open($zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
        foreach ($badges as $badge) {
            $user = User::find($badge->user_id);
            $dir = $user->forename . '_' . $user->surname;
            $zip->addEmptyDir($dir);
            $zip->addFromString(
                Storage::get('members/1/mug_shot.jpg'), $dir . "mug_shot.jpg"
            );


        }
        //$zip->close();
        $response = Response::make($zip_file, 200);
        $response->header("Content-Type", "application/zip");

        return $response;

    }
}
