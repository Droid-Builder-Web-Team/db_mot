<?php

namespace App\Http\Controllers;

use App\User;
use App\Club;
use Illuminate\Http\Request;

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
}
