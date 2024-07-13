<?php

/**
 * Event Controller
 * php version 7.4
 *
 * @category Controller
 * @package  Controllers
 * @author   Darren Poulson <darren.poulson@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Event;
use App\User;
use App\Location;
use App\Comment;
use App\Contact;
use DateTime;
use App\Notifications\EventUpdated;
use App\Notifications\UserEventCreated;
use Spatie\CalendarLinks\Link;
use DPoulson\LaravelCalendar\Calendar;
use CountryState;
use Illuminate\Support\Facades\Auth;
use Flasher\Prime\FlasherInterface;

/**
 * EventController
 *
 * @category Class
 * @package  Controllers
 * @author   Darren Poulson <darren.poulson@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */
class EventController extends Controller
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
        if (auth()->user()->accepted_coc == 0) {
            return redirect('codeofconduct');
        }

        $events = Event::whereDate('date', '>=', Carbon::now())
            ->where('approved', '1')
            ->orderBy('date', 'asc')->get();

        $calevents = [];

        foreach ($events as $event) {
            $title = $event->name . ' - ('
                . $event->location->name . ' - '
                . $event->location->town . ')';
            $background = "lightgrey";
            if (Auth()->user()->event($event->id)) {
                $background = "green";
            }
            $calevents[] = Calendar::event(
                $event->name,
                true,
                $event->date,
                $event->date,
                $event->id,
                [
                'url' => 'event/'.$event->id,
                'title' => $title,
                'borderColor' =>  $background,

                ]
            );
        }


        $calendar = new Calendar();
        $calendar->addEvents($calevents)
            ->setOptions(
                [
                'locale' => 'en',
                'themeSystem' => 'bootstrap',
                'aspectRatio' => 2.5,
                'height' => 'auto',
                'firstDay' => 0,
                'titleFormat' => [
                'month' => 'short',
                'year' => 'numeric'
                ],
                'views' => [
                'listYear' => [
                    'titleFormat' => [
                        'year' => 'numeric',
                      ]
                ],
                ],
                'displayEventTime' => false,
                'selectable' => true,
                'initialView' => 'listYear',
                'bootstrapFontAwesome' => [
                'today' => 'calendar-day',
                'dayGridMonth' => 'fa-calendar-alt',
                'listMonth' => 'fa-list'
                ],
                'buttonText' => [
                'listYear' => 'Year',
                ],
                'buttonIcons' => [

                ],
                'customButtons' => [
                'map' => [
                    'text' => 'View as Map',
                    'click' => 'function() {
                        window.open("event/map","_self")
                    }'
                ]
                ],
                'headerToolbar' => [
                'end' => 'map today,prev,next dayGridMonth,listMonth,listYear'
                ]
                ]
            );
        $calendar->setId('1');

        return view('event.index', compact('calendar'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $locations = Location::all();
        $countries = CountryState::getCountries();
        rsort($countries);
        return view('event.create', compact(['locations', 'countries']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
            'name' => 'required',
            'description' => 'required',
            'date' => 'required',
            ]
        );

        if($request->location_id == "---") {
            flash()->addError('Please enter a location');
            return back()->withInput();
        }

        if($request->location_id == "new") {
            // Create a new location
            if ($request['postcode'] != "") {
                $address = str_replace(' ', '+', $request['postcode']).'+'.str_replace(' ', '+', $request['country']);
                $url = "https://maps.google.com/maps/api/geocode/json?key=".config('gmap.google_api_key')."&address=".$address."&sensor=false";
                $geocode = file_get_contents($url);
                $output = json_decode($geocode);
                $location['latitude'] = strval($output->results[0]->geometry->location->lat);
                $location['longitude'] = strval($output->results[0]->geometry->location->lng);
            } else {
                $location['latitude'] = "";
                $location['longitude'] = "";
            }

            $location['name'] = $request->location_name;
            $location['street'] = $request->street;
            $location['town'] = $request->town;
            $location['county'] = $request->county;
            $location['country'] = $request->country;
            $location['postcode'] = $request->postcode;

            try {
                $newlocation = Location::create($location);
                flash()->addSuccess('Location created successfully');
            } catch (\Illuminate\Database\QueryException $exception) {

                flash()->addError('Failed to create Location');
                return back()->withInput();
            }
            $event['location_id'] = $newlocation->id;
            $request['location_id'] = $event['location_id'];    // If location is created successfully, set request incase event can't be created
        } else {
            $event['location_id'] = $request->location_id;
        }

        if ($request['url'] != "") {
            if (!str_starts_with($request['url'], 'http')) {
                $event['url'] = "http://".$request['url'];
            }
        } else {
            $event['url'] = "";
        }

        $event['name'] = $request->name;
        $event['parking_details'] = $request->parking_details;
        $event['quantity'] = $request->quantity;
        $event['public'] = $request->public;
        $event['date'] = $request->date;
        $event['wip_allowed'] = 0;
        $event['mot'] = 0;
        $linkify = new \Misd\Linkify\Linkify();
        $event['description'] = $linkify->process($request->description);
        $event['created_by'] = Auth::id();
        $event['approved'] = 0;
        $event['sw_only'] = $request->sw_only;

        try {
            $newevent = Event::create($event);
            flash()->addSuccess('Event submitted for admin approval');
        } catch (\Illuminate\Database\QueryException $exception) {
            flash()->addError('Failed to submit event');
            return back()->withInput();
        }

        $officers = User::role('Events Officer')->get();
        foreach ($officers as $officer) {
            $officer->notify(new UserEventCreated($newevent));
        }

        if ($request->days != 1) {
            for ($x = 1; $x <= $request->days - 1; $x++) {
                $event['date'] = date(
                    'Y-m-d',
                    strtotime(
                        $request->date. ' + ' . $x . ' days'
                    )
                );
                $newevent = Event::create($event);
                foreach ($officers as $officer) {
                    $officer->notify(new UserEventCreated($newevent));
                }
            }
        }

        return redirect()->route('event.index');

    }

    /**
     * Display the specified resource.
     *
     * @param int $id ID of event to show
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event = Event::where('id', $id)->first();
        $contacts = Contact::all();
        if ($event == null) {
            flash()->addError('No such event');
            return redirect('/event');
        } else {
            $date = DateTime::createFromFormat('Y-m-d', $event->date);
            $link = Link::create(
                $event->name,
                $date,
                $date,
                true
            )
                    ->description($event->description)
                    ->address($event->location->name.','.$event->location->postcode);

            return view('event.show', compact('event', 'link', 'contacts'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request Data to update
     * @param \App\Event               $event   Event to update
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {

        $user = User::find($request->user_id);
        $hasEntry = $user->events()->where('event_id', $event->id)->exists();
        $attributes = [
          'spotter' => $request->spotter,
          'status' => $request->going,
          'mot_required' => $request->mot_required
        ];
        if ($hasEntry) {
            $result = $event->users()->updateExistingPivot($user, $attributes);
            flash()->addSuccess('Interest updated for Event');
        } elseif ($event->isFull()) {
            flash()->addError('Sorry, event is full');
        } else {
            $result = $event->users()->save($user, $attributes);
            flash()->addSuccess('Interest registered for Event');
        }
        return back();
    }

    /**
     * Show past events
     *
     * @return view
     */
    public function past()
    {
        $events = Event::whereDate('date', '<=', Carbon::now())
            ->orderBy('date', 'desc')->paginate(25);

        return view('event.past', compact('events'));
    }

    /**
     * Show events on a map
     *
     * @return view
     */
    public function map()
    {
        $key = config('gmap.google_api_key');
        $events = Event::whereDate('date', '>=', Carbon::now())->get();

        $eventlist = [];
        $index = 0;
        foreach ($events as $event) {
            $entry = array();
            $entry['id'] = $index;
            $entry['uid'] = $event->id;
            $entry['title'] = $event->name . ' - ('
                . $event->location->name . ' - '
                . $event->location->town . ')';
            $entry['url'] = "<a href=".route(
                'event.show',
                ['event' => $event->id]
            ).">".$entry['title']."</a>";
            $entry['extra'] = $event->date;
            $entry['position'] = array(
                "lat" => floatval($event->location->latitude),
                "lng" => floatval($event->location->longitude)
            );

            array_push($eventlist, $entry);
            $index++;
        }

        return view('event.map', compact('eventlist'));
    }

}
