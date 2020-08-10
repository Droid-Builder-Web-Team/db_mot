<?php

namespace App\Http\Controllers;

use App\Droid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class DroidController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    public function displayDroidImage($uid, $view)
    {
        $path = 'droids/'.$uid.'/'.$view.'.jpg';
        $file = Storage::get($path);
        $type = Storage::mimeType($path);
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }
}
