<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Droid;

class ToppsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $droids = Droid::where('topps_id', '!=', 0)
            ->where('topps_run', '==', 1)
            ->orderBy('topps_id')
            ->paginate(8);
        return view('topps', compact('droids'));
    }

    public function displayToppsImage($uid, $view, $size = '')
    {
        $droid = Droid::find($uid);

        if (!in_array($view, array('topps_front', 'topps_rear'))) {
            abort(403);
        }

        if ($size != "") {
            $size = $size.'-';
        }
        $path = 'droids/'.$uid.'/'.$size.''.$view.'.png';
        if (!Storage::exists($path)) {
            $path = 'droids/'.$uid.'/'.$size.''.$view.'.jpg';
        }
        if (!Storage::exists($path)) {
            $path = getcwd().'/img/blank_'.$view.'.jpg';
            $file = file_get_contents($path);
            $type = "image/jpeg";
        } else {
            $file = Storage::get($path);
            $type = Storage::mimeType($path);
        }
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }
}
