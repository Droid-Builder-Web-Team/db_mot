<?php

namespace App\Http\Controllers\Admin;

use App\Event;
use App\Location;
use App\User;
use App\Comment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\DataTables\EventsDataTable;
use App\Notifications\EventCreated;
use App\Notifications\EventChanged;
use App\Notifications\EventCancelled;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;


class EventsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:Edit Events');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(EventsDataTable $dataTable)
    {
        return $dataTable->render('admin.events.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $locations = Location::all();
        return view('admin.events.create', compact('locations'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'date' => 'required'
        ]);

        $event = $request->all();
        $linkify = new \Misd\Linkify\Linkify();
        $event['description'] = $linkify->process($request->description);

        $success = 0;
        try {
          $newevent = Event::create($event);
          toastr()->success('Event created successfully');
          $success = 1;
        } catch (\Illuminate\Database\QueryException $exception) {
          toastr()->error('Failed to create Event ');
        }

        $newevent->createdEventNotification($newevent);

        return redirect()->route('admin.events.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        $locations = Location::all();
        return view('admin.events.edit', compact('locations'))->with('event', $event);
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
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $newevent = $request->all();
        $linkify = new \Misd\Linkify\Linkify();
        $newevent['description'] = $linkify->process($request->description);
        try {
          $event->update($newevent);
          toastr()->success('Event updated successfully');
        } catch (\Illuminate\Database\QueryException $exception) {
          toastr()->error('Failed to upuse Illuminate\Support\Facades\Storage;
            use Illuminate\Support\Facades\Response;date Event');
        }

        if($event->isFuture())
        {
            foreach($event->users as $user)
            {
                $user->notify(new EventChanged($event));
            }
            // Only notify discord if its a future event.
            $event->updatedEventNotification($event);
        }


        return redirect()->route('admin.events.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        $event->delete();

        try {
          $event->delete();
          toastr()->success('Event deleted successfully');
        } catch (\Illuminate\Database\QueryException $exception) {
          toastr()->error('Failed to delete Event');
        }

        // Don't need to notify discord if event gets deleted.
        //$event->deletedEventNotification($event);
        return redirect()->route('admin.events.index');
    }

    public function confirm($event_id, $user_id)
    {
        $user = User::find($user_id);
        $user->events()->updateExistingPivot($event_id, ["attended" => 1]);
        return back();
    }

    public function deny($event_id, $user_id)
    {
        $user = User::find($user_id);
        $user->event($event_id)->delete();
        return back();
    }

    public function addimage($event_id)
    {
        $event = Event::find($event_id);
        return view('admin.events.addimage', compact('event'));
    }

    public function storeimage(Request $request)
    {
        // Check image
        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'mimes:jpeg,bmp,png' // Only allow .jpg, .bmp and .png file types.
            ]);
        }

        $eventImage = $request->image->storeAs('events/'.$request->event_id.'/', 'event_image.jpg');

        return redirect()->route('event.show', $request->event_id);
    }

}
