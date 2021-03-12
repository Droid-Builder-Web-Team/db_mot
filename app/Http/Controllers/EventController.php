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
                  ->orderBy('date', 'asc')->paginate(15);

        return view('event.index', compact('events'))
          ->with('i', (request()->input('page', 1) -1) *15);
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
        $date = DateTime::createFromFormat('Y-m-d', $event->date);
        $link = Link::create($event->name,
                            $date,
                            $date,
                            true)
                            ->description($event->description)
                            ->address($event->location->name.','.$event->location->postcode);
        return view('event.show', compact('event', 'link'));
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

    public function comment(Request $request, Event $event)
    {

        $comment = new Comment;
        $comment->body = $request->body;
        $comment->user_id = auth()->user()->id;

        if (auth()->user()->can('Edit Events') && $request->broadcast == 'on')
        {
          foreach($event->users as $user)
          {
            $user->notify(new EventUpdated($event));
          }
          $comment->broadcast = true;
        }

        $result = $event->comments()->save($comment);
        toastr()->success('Comment Added');
        return back();
    }

}
