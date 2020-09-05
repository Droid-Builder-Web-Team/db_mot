<?php

namespace App\Http\Controllers;

use App\Droid;
use App\MOT;
use App\Club;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class DroidController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
      $this->middleware('verified');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clubs = Club::all();
        return view('droid.create', compact('clubs'));
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
            'name' => 'required'
        ]);

        $droid = Droid::create($request->all());
        $droid->users()->attach(auth()->user()->id);
        return redirect()->route('user.show', auth()->user()->id )
                        ->with('success','Droid created successfully.');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Droid  $droid
     * @return \Illuminate\Http\Response
     */
    public function show(Droid $droid)
    {
        if ($droid->users->contains(auth()->user()) || auth()->user()->can('View Droids'))
        {
            return view('droid.show', compact('droid'));
        } else
        {
            abort(403);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Droid  $droid
     * @return \Illuminate\Http\Response
     */
    public function edit(Droid $droid)
    {
        $clubs = Club::all();
        return view('droid.edit', compact('clubs'))->with('droid', $droid);;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Droid  $droid
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Droid $droid)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $droid->update($request->all());

        $notification = array(
            'message' => 'Droid updated successfully.',
            'alert-type' => 'success'
        );
        return redirect()->route('droid.show', $droid->id)
                        ->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Droid  $droid
     * @return \Illuminate\Http\Response
     */
    public function destroy(Droid $droid)
    {
        $users = $droid->users;
        foreach($users as $user)
        {
            $droid->users()->detach($user->id);
        }
        $mots = $droid->mot;
        foreach($mots as $mot)
        {
            $droid->mot()-detach($droid->id);
        }
        $droid->delete();

        return redirect()->route('user.show', auth()->user()->id)
                        ->with('success','Droid deleted successfully');
    }

    public function displayDroidImage($uid, $view)
    {
        $path = 'droids/'.$uid.'/'.$view.'.png';
        if (!Storage::exists($path)) {
            $path = 'droids/'.$uid.'/'.$view.'.jpg';
        }
        if (!Storage::exists($path)) {
            $path = getcwd().'/img/blank_'.$view.'.jpg';
            $file = file_get_contents($path);
            $type = "image/jpeg";
        } else {
            $file = Storage::get($path);
            $type = Storage::mimeType($path);
        }
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }

}
