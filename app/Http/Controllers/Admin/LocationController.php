<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Location;
use Illuminate\Http\Request;
use App\DataTables\LocationsDataTable;

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
    public function index(LocationsDataTable $dataTable)
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

        try {
          Location::create($request->all());
          toastr()->success('Location created successfully');
        } catch (\Illuminate\Database\QueryException $exception) {
          toastr()->error('Failed to create Location');
        }

        return redirect()->route('admin.locations.index');
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
          'postcode' => 'required',
      ]);

      try {
          $location->update($request->all());
          toastr()->success('Location updated successfully');
      } catch (\Illuminate\Database\QueryException $exception) {
          toastr()->error('Failed to update Location');
      }

      return redirect()->route('admin.locations.index');
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
