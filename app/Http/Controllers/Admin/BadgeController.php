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
        $users = DB::table('id_list')
            ->select('user_id', 'reissue', 'paid')
            ->distinct('user_id')->get();

        $zip = new ZipArchive();
        $zip_file = "test.zip";
        $zip->open($zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
        $columns = array(
            'Forename',
            'Surname',
            'Member ID',
            'Email',
            'PLI Paid',
            'ReIssue',
            'Droid ID'
        );
        $csv_filename = "id_list.csv";
        $fp = fopen($csv_filename, 'w');
        fputcsv($fp, $columns);
        foreach ($users as $userid) {
            $user = User::find($userid->user_id);

            $dir = $user->forename . '_' . $user->surname;
            $zip->addEmptyDir($dir);

            // Get QR code image
            $path = 'members/'.$user->id.'/qr_code.png';
            $qr_extension = 'png';
            if (!Storage::exists($path)) {
                $path = 'members/'.$user->id.'/qr_code.jpg';
                $qr_extension = 'jpg';
            }
            $qrcode = Storage::get($path);

            // Get Mug Shot image
            $path = 'members/'.$user->id.'/mug_shot.png';
            $mug_extension = 'png';
            if (!Storage::exists($path)) {
                $path = 'members/'.$user->id.'/mug_shot.jpg';
                $mug_extension = 'jpg';
            }
            if (!Storage::exists($path)) {
                $path = getcwd().'/img/blank_mug_shot.jpg';
                $mugshot = file_get_contents($path);
                $mug_extension = "jpg";
            } else {
                $mugshot = Storage::get($path);
            }

            // Add to zip file
            $zip->addFromString(
                $dir . '/qr_code' . '.' .  $qr_extension,
                $qrcode
            );
            $zip->addFromString(
                $dir . '/mug_shot' . '.' .  $mug_extension,
                $mugshot . '.' .  $mug_extension
            );

            if ($userid->reissue) {
                $zip->addFromString(
                    $dir . '/reissue.txt',
                    'This is a reissue due to lost card or updating picture.'
                );
            }

            $droids = DB::table('id_list')
                ->where('user_id', $userid->user_id)
                ->get();

            foreach ($droids as $droid) {
                // Get Mug Shot image
                $path = 'droids/'.$droid->droid_id.'/photo_front.png';
                $droid_extension = 'png';
                if (!Storage::exists($path)) {
                    $path = 'droids/'.$droid->droid_id.'/photo_front.jpg';
                    $droid_extension = 'jpg';
                }
                if (!Storage::exists($path)) {
                    $path = getcwd().'/img/blank_photo_front.jpg';
                    $droid_image = file_get_contents($path);
                    $droid_extension = "jpg";
                } else {
                    $droid_image = Storage::get($path);
                }

                $zip->addFromString(
                    $dir . '/droid_' . $droid->droid_id . '.' .  $droid_extension,
                    $droid_image . '.' .  $droid_extension
                );

                if ($clear == "true") {
                    DB::table('id_list')
                        ->where(
                            [
                                [  'user_id', $userid->user_id ],
                                [ 'droid_id', $droid->droid_id ]
                            ]
                        )->delete();
                }
                fputcsv($fp, array(
                    $user->forename,
                    $user->surname,
                    $user->id,
                    $user->email,
                    $user->validPLI(),
                    $userid->reissue,
                    $droid->droid_id
                ));
            }

            

        }
        fclose($fp);
        $zip->addFile($csv_filename, 'id_list.csv');
        $zip->close();

        $headers = array(
            'Content-Type' => 'application/zip',
        );
        return response()->download($zip_file, 'id_badges.zip', $headers);

    }
}
