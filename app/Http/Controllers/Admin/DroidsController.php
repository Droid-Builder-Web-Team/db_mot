<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Droid;
use App\User;
use Illuminate\Http\Request;

class DroidsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:View Droids');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $droids = Droid::orderBy('droids_uid', 'asc')->paginate(15);

        return view('admin.droids.index', compact('droids'))
          ->with('i', (request()->input('page', 1) -1) *15);
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
        //
        return view('droids.show', compact('droid'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Droid  $droid
     * @return \Illuminate\Http\Response
     */
    public function edit(Droid $droid)
    {
        return view('admin.droids.edit')->with('droid', $droid);
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
}
