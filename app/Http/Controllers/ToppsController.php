<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Droid;

class ToppsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        $droids = Droid::where('topps_id', '!=', 0)
                    ->orderBy('topps_id')
                    ->get();
        return view('topps', compact('droids'));
    }
}
