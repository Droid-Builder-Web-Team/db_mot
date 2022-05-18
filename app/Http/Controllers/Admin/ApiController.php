<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Droid;
use App\Club;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{

    public function list_bcreps($club_id)
    {
        $reps = [];
        $club = Club::find($club_id);

        $allreps = User::role('BC Rep')->get(['id', 'surname', 'forename']);
        foreach($allreps as $rep)
        {
            if($rep->isAdminOf($club)) {
                array_push($reps, $rep);
            }
        }

        return response()->json($reps);
    }

    public function drivingCourseDownload()
    {
        $data = User::with('droids')->get();
        $data->makeHidden(['api_token', 'badge_id', 'calendar_id', 'droid.notes']);
        return response()->json(strip_tags($data));
    }
}
