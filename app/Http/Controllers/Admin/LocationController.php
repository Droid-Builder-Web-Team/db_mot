<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
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
    public function index()
    {
        $locations = Location::orderBy('location_uid', 'asc')->paginate(15);

        return view('admin.locations.index', compact('locations'))
          ->with('i', (request()->input('page', 1) -1) *15);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.locations.create');
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
            'postcode' => 'required'
        ]);

        Location::create($request->all());

        return redirect()->route('admin.locations.index')
                        ->with('success','Location created successfully.');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function edit(Location $location)
    {
        return view('admin.locations.edit')->with('location', $location);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Location $location)
    {
      $request->validate([
          'name' => 'required',
          'town' => 'required',
      ]);

      $location->update($request->all());

      return redirect()->route('admin.locations.index')
                      ->with('success','Location updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location)
    {
      $location->delete();

      return redirect()->route('admin.locations.index')
                      ->with('success','Location deleted successfully');
    }
}
