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
        $droid->users()->attach($request['id']);
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
        return view('droid.show', compact('droid'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Droid  $droid
     * @return \Illuminate\Http\Response
     */
    public function edit(Droid $droid)
    {
        //
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
        //
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
