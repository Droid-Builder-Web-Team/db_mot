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

namespace App\Http\Controllers\Admin;

use App\Event;
use App\Location;
use App\Notifications\UserEventApproved;
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
use Illuminate\Support\Facades\Auth;

/**
 * EventController
 *
 * @category Class
 * @package  Controllers
 * @author   Darren Poulson <darren.poulson@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */
class EventsController extends Controller
{

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:Edit Events');
    }

    /**
     * Display a listing of the resource.
     *
     * @param EventsDataTable $dataTable Datatable for Events
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
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $locations = Location::all();
        return view('admin.events.create', compact('locations'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request Request Data
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        $request->validate(
            [
            'name' => 'required',
            'description' => 'required',
            'date' => 'required'
            ]
        );


        if ($request['url'] != "") {
            if (!str_starts_with($request['url'], 'http')) {
                $request['url'] = "http://".$request['url'];
            }
        }
        $event = $request->all();
        $linkify = new \Misd\Linkify\Linkify();
        $event['description'] = $linkify->process($request->description);
        $event['created_by'] = Auth::id();

        $success = 0;
        try {
            $newevent = Event::create($event);
            flash()->addSuccess('Event created successfully');
            $success = 1;
        } catch (\Illuminate\Database\QueryException $exception) {
            flash()->addError('Failed to create Event ');
            return back();
        }

        $newevent->createdEventNotification($newevent);

        if ($request->days != 1) {
            for ($x = 1; $x <= $request->days - 1; $x++) {
                $event['date'] = date(
                    'Y-m-d', strtotime(
                        $request->date. ' + ' . $x . ' days'
                    )
                );
                $newevent = Event::create($event);
            }
        }

        return redirect()->route('admin.events.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Event $event Event model to edit
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        $locations = Location::all();
        return view(
            'admin.events.edit', compact(
                'locations'
            )
        )->with('event', $event);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request Request data
     * @param \App\Event               $event   Event to update
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Event $event)
    {
        $request->validate(
            [
            'name' => 'required',
            'description' => 'required',
            ]
        );

        if ($request['url'] != "") {
            if (!str_starts_with($request['url'], 'http')) {
                $request['url'] = "http://".$request['url'];
            }
        }

        $approved = 0;
        if ($event->approved == 0 && $request['approved'] == 1) {
            $approved = 1;
        }
        $newevent = $request->all();
        $linkify = new \Misd\Linkify\Linkify();
        $newevent['description'] = $linkify->process($request->description);
        try {
            $event->update($newevent);
            if ($approved == 1) {
                // Notify submitter that their event has been approved
                $user = User::find($event['created_by']);
                $user->notify(new UserEventApproved($event));
                flash()->addSuccess('User notified of event approval');
            }
            flash()->addSuccess('Event updated successfully');
        } catch (\Illuminate\Database\QueryException $exception) {
            flash()->addError(
                'Failed to update Event'
            );
        }

        if ($event->isFuture()) {
            foreach ($event->users as $user) {
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
     * @param \App\Event $event Event to delete
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Event $event)
    {
        $event->delete();

        try {
            $event->delete();
            flash()->addSuccess('Event deleted successfully');
        } catch (\Illuminate\Database\QueryException $exception) {
            flash()->addError('Failed to delete Event');
        }

        // Don't need to notify discord if event gets deleted.
        //$event->deletedEventNotification($event);
        return redirect()->route('admin.events.index');
    }

    /**
     * Confirm attendance
     *
     * @param int $event_id Event ID
     * @param int $user_id  User ID
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function confirm($event_id, $user_id)
    {
        $user = User::find($user_id);
        $user->events()->updateExistingPivot($event_id, ["attended" => 1]);
        return back();
    }

    /**
     * Deny
     *
     * @param int $event_id Event ID
     * @param int $user_id  User ID
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deny($event_id, $user_id)
    {
        $user = User::find($user_id);
        $user->events()->updateExistingPivot($event_id, ["attended" => -1]);
        return back();
    }

    /**
     * Add image
     *
     * @param int $event_id Event ID
     *
     * @return void
     */
    public function addimage($event_id)
    {
        $event = Event::find($event_id);
        return view('admin.events.addimage', compact('event'));
    }

    /**
     * Store an image
     *
     * @param \Illuminate\Http\Request $request Image to store
     *
     * @return void
     */
    public function storeimage(Request $request)
    {
        // Check image
        if ($request->hasFile('image')) {
            $request->validate(
                [
                'image' => 'mimes:jpeg,bmp,png'
                ]
            );
        }

        $eventImage = $request->image->storeAs(
            'events/'.$request->event_id.'/', 'event_image.jpg'
        );

        return redirect()->route('event.show', $request->event_id);
    }

    /**
     * Export
     *
     * @param int $id Event ID
     *
     * @return void
     */
    public function export($id)
    {
        if (!auth()->user()->can('Edit Events')) {
            abort(403);
        }

        $event = app(Event::class)->find($id);

        $fileName = 'attendance.csv';

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array(
            'Forename',
            'Surname',
            'Status',
            'Spotter',
            'MOT Requested'
        );

        $callback = function () use ($event, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($event->users as $user) {
                $row['Forename']      = $user->forename;
                $row['Surname']       = $user->surname;
                $row['Status']        = $user->pivot->status;
                $row['Spotter']       = $user->pivot->spotter;
                $row['MOT Requested'] = $user->pivot->mot_required;
                $row['Email']         = $user->email;

                fputcsv(
                    $file, array(
                        $row['Forename'],
                        $row['Surname'],
                        $row['Status'],
                        $row['Spotter'],
                        $row['MOT Requested'],
                        $row['Email']
                        )
                );
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

}
