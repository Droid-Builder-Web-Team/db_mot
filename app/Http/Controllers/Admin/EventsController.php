<?php

namespace App\Http\Controllers\Admin;

use App\Event;
use App\Location;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\DataTables\EventsDataTable;
use App\Notifications\EventCreated;
use App\Notifications\EventChanged;
use App\Notifications\EventCancelled;

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

        try {
          $event = Event::create($request->all());
          toastr()->success('Event created successfully');
        } catch (\Illuminate\Database\QueryException $exception) {
          toastr()->error('Failed to create Event ');
        }

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

        foreach($event->users as $user)
        {
            $user->notify(new EventChanged($event));
        }

        try {
          $event->update($request->all());
          toastr()->success('Event updated successfully');
        } catch (\Illuminate\Database\QueryException $exception) {
          toastr()->error('Failed to update Event');
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

        return redirect()->route('admin.events.index');
    }
}
