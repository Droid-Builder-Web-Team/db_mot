<?php

/**
 * Location Controller
 * php version 7.4
 *
 * @category Controller
 * @package  Controllers
 * @author   Darren Poulson <darren.poulson@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */

namespace App\Http\Controllers;

use App\Location;
use App\Comment;
use App\User;
use App\Event;
use App\Contact;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

/**
 * LocationController
 *
 * @category Class
 * @package  Controllers
 * @author   Darren Poulson <darren.poulson@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */
class LocationController extends Controller
{

    /**
     * __construct
     *
     * @return void
     */
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
     * @param \App\Location $location Location to show
     *
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

        $contacts = Contact::all();

        return view(
            'location.show', compact(
                'location', 'events', 'upcoming', 'contacts'
            )
        );
    }

    /**
     * Store updates
     *
     * @param \Illuminate\Http\Request $request  Request with data
     * @param \App\Location            $location Location to update
     *
     * @return void
     */
    public function store(Request $request, Location $location)
    {
        $location = Location::find($location->id);
        $user = auth()->user();

        $userRating = $request->input('locationRating');

        if ($user->hasRated($location)) {
            $user->updateRatingFor($location, $userRating);
        } else {
            $user->rate($location, $userRating);
        }
        return redirect()->back();
    }

}
