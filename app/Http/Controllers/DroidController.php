<?php

namespace App\Http\Controllers;

use App\Droid;
use App\MOT;
use App\Club;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use PDF;

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

        try {
          $droid = Droid::create($request->all());
          toastr()->success('Droid created successfully');
        } catch (\Illuminate\Database\QueryException $exception) {
          toastr()->error('Failed to create Droid');
        }

        try {
          $droid->users()->attach(auth()->user()->id);
          toastr()->success('Droid attached to your account successfully');
        } catch (\Illuminate\Database\QueryException $exception) {
          toastr()->error('Failed to attach Droid');
        }

        return redirect()->route('user.show', auth()->user()->id );

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
        if ($droid->users->contains(auth()->user()) || auth()->user()->can('Edit Droids'))
        {
            return view('droid.edit', compact('clubs'))->with('droid', $droid);;
        } else
        {
            abort(403);
        }

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

        if (!$droid->users->contains(auth()->user()) || !auth()->user()->can('Edit Droids'))
        {
            abort(403);
        }

        $request->validate([
            'name' => 'required',
        ]);

        try {
          $droid->update($request->all());
          toastr()->success('Droid updated successfully');
        } catch (\Illuminate\Database\QueryException $exception) {
          toastr()->error('Failed to update Droid');
        }
        return redirect()->route('droid.show', $droid->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Droid  $droid
     * @return \Illuminate\Http\Response
     */
    public function destroy(Droid $droid)
    {

        if (!$droid->users->contains(auth()->user()) || !auth()->user()->can('Edit Droids'))
        {
            abort(403);
        }

        $users = $droid->users;
        foreach($users as $user)
        {
            $droid->users()->detach($user->id);
        }
        $mots = $droid->mot;
        foreach($mots as $mot)
        {
            $droid->mot()->delete();
        }
        $droid->delete();

        try {
          $droid->delete();
          toastr()->success('Droid deleted successfully');
        } catch (\Illuminate\Database\QueryException $exception) {
          toastr()->error('Failed to delete Droid');
        }

        return redirect()->route('user.show', auth()->user()->id);
    }

    public function displayDroidImage($uid, $view, $size = '')
    {
        $droid = Droid::find($uid);
        if (!$droid->users->contains(auth()->user()) && !auth()->user()->can('View Droids'))
        {
            abort(403);
        }

        if ($size != "")
          $size = $size.'-';
        $path = 'droids/'.$uid.'/'.$size.''.$view.'.png';
        if (!Storage::exists($path)) {
            $path = 'droids/'.$uid.'/'.$size.''.$view.'.jpg';
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

    public function downloadPDF($id) {
        $droid = Droid::find($id);
        $user = User::find($droid->users->first()->id);
        $pdf = PDF::loadView('droid.info', compact('droid', 'user'));
        $pdf->defaultFont = 'Arial';
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('cover_note.pdf');
        //return view('droid.info', compact('droid', 'user'));
    }
}
