<?php

namespace App\Http\Controllers;

use App\Location;
use App\Comment;
use App\User;
use App\Event;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class LocationController extends Controller
{

    public function __construct()
    {
      $this->middleware('auth');
      $this->middleware('verified');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show(Location $location)
    {
        $ratings = DB::table('ratings')
            ->where('rateable_id', $location->id)
            ->get();

        $events = Event::where('location_id', $location->id)
            ->whereDate('date', '<=', Carbon::now())
            ->orderBy('date', 'desc')
            ->get();

        $upcoming = Event::where('location_id', $location->id)
            ->whereDate('date', '>=', Carbon::now())
            ->orderBy('date', 'desc')
            ->get();

        return view('location.show', compact('location', 'events', 'upcoming'));
    }

    public function store(Request $request, Location $location)
    {
        $location = Location::find($location->id);
        $user = auth()->user();

        $userRating = $request->input('locationRating');

        if ($user->hasRated($location))
        {
            $user->updateRatingFor($location,$userRating);
        } else {
            $user->rate($location, $userRating);
        }
        return redirect()->back();
    }

}
