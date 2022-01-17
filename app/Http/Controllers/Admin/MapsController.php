<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class MapsController extends Controller
{
    public function index()
    {
        $key = config('gmap.google_api_key');
        $users = User::where('latitude', '!=', '')
            ->where('active', 'on')
            ->get(['forename', 'surname', 'latitude', 'longitude', 'id', 'pli_date']);

        $userlist = [];
        $index = 0;
        foreach ($users as $user) {
            $entry = array();
            $entry['id'] = $index;
            $entry['uid'] = $user->id;
            $entry['title'] = $user->forename . " " . $user->surname;
            $entry['url'] = "<a href=".route('user.show', ['user' => $user->id]).">".$entry['title']."</a>";
            $entry['extra'] = "Droids: " . $user->droids->count() . "</br>PLI Status: " .
                    ($user->validPLI() ? "Valid" : "None");
            $entry['position'] = array(
                "lat" => floatval($user->latitude),
                "lng" => floatval($user->longitude)
            );

            array_push($userlist, $entry);
            $index++;
        }

        return view('admin.maps.index', compact('userlist'));
    }
}
