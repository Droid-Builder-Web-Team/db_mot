<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Event;
use App\User;
use App\Location;
use App\Comment;
use DateTime;
use App\Notifications\EventUpdated;
use Spatie\CalendarLinks\Link;
use Acaronlex\LaravelCalendar\Calendar;

class EventController extends Controller
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
        if(auth()->user()->accepted_coc == 0)
        {
            return redirect('codeofconduct');
        }

        $events = Event::whereDate('date', '>=', Carbon::now())
                  ->orderBy('date', 'asc')->get();

        $calevents = [];

        foreach($events as $event){
          $title = $event->name.' - ('.$event->location->name.' - '.$event->location->town.')';
          $background = "lightgrey";
          if(Auth()->user()->event($event->id)){
            $background = "green";
          }
          $calevents[] = Calendar::event(
            $event->name,
            True,
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
        ->setOptions([
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
            'displayEventTime' => False,
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
            'headerToolbar' => [
                'end' => 'today,prev,next dayGridMonth,listMonth,listYear'
            ]
        ]);
        $calendar->setId('1');

        return view('event.index', compact('calendar'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event = Event::where('id', $id)->first();
        if($event == null) {
            toastr()->error('No such event');
            return redirect('/event');
        } else {
            $date = DateTime::createFromFormat('Y-m-d', $event->date);
            $link = Link::create($event->name,
                            $date,
                            $date,
                            true)
                            ->description($event->description)
                            ->address($event->location->name.','.$event->location->postcode);
            return view('event.show', compact('event', 'link'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Event  $event
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
        if ($hasEntry)
            $result = $event->users()->updateExistingPivot($user, $attributes);
        else
            $result = $event->users()->save($user, $attributes);
        toastr()->success('Interest registered for Event');
        return back();
    }

    public function past() {
	    $events = Event::whereDate('date', '<=', Carbon::now())
                  ->orderBy('date', 'desc')->paginate(25);

	    return view('event.past', compact('events'));
    }

    public function map() {
        $key = config('gmap.google_api_key');
        $events = Event::whereDate('date', '>=', Carbon::now())->get();

        $eventlist = [];
        $index = 0;
        foreach($events as $event) {
            $entry = array();
            $entry['id'] = $index;
            $entry['uid'] = $event->id;
            $entry['title'] = $event->date.' - '.$event->name.' - ('.$event->location->name.' - '.$event->location->town.')';
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
