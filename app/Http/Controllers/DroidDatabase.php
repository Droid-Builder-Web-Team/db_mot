<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\Validator;
use App\Club;
use App\Droid;

class DroidDatabase extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
    }

    public function index()
    {
        $clubs = Club::all();
        $droids = Droid::where('public', 'Yes')->get();
        return view('database.index', compact(['clubs', 'droids']));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Droid $droid
     * @return \Illuminate\Http\Response
     */
    public function show($droid)
    {
        $droid = Droid::find($droid);
        return view('database.show', compact('droid'));
    }
}
