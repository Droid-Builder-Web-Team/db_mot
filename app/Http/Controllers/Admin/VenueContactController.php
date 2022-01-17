<?php

namespace App\Http\Controllers\Admin;

use App\Location;
use App\VenueContact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\VenueContactDataTable;

class VenueContactController extends Controller
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
    public function index(VenueContactDataTable $dataTable)
    {
        return $dataTable->render('admin.venue-contacts.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $locations = app(Location::class)->all();
        return view(
            'admin.venue-contacts.create', [
            'locations' => $locations,
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
            'locations_id' => 'reguired',
            'contact_name' => 'required',
            'contact_email' => 'required',
            'contact_number' => 'required'
            ]
        );

        dd($request);

        try {
            VenueContact::create($request->all());
            toastr()->success('Venue Contact created successfully');
        } catch (\Illuminate\Database\QueryException $exception) {
            toastr()->error('Failed to create Venue Contact');
        }

        return redirect()->route('admin.venue-contacts.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\VenueContact $location
     * @return \Illuminate\Http\Response
     */
    public function edit(VenueContact $venueContact)
    {
        return view('admin.venue-contacts.edit')->with('venueContact', $venueContact);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\VenueContact        $location
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VenueContact $venueContact)
    {
        $request->validate(
            [
            'name' => 'required',
            'postcode' => 'required',
            ]
        );

        try {
            $venueContact->update($request->all());
            toastr()->success('Venue Contact updated successfully');
        } catch (\Illuminate\Database\QueryException $exception) {
            toastr()->error('Failed to update Venue Contact');
        }

        return redirect()->route('admin.venue-contacts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\VenueContact $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(VenueContact $venueContact)
    {
        $venueContact->delete();

        return redirect()->route('admin.venue-contacts.index')
            ->with('success', 'Venue Contact deleted successfully');
    }
}
