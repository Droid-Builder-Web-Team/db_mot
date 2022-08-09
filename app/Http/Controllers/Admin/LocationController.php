<?php
/**
 * Locations Admin Controller
 * php version 7.4
 *
 * @category Controller
 * @package  Controllers
 * @author   Darren Poulson <darren.poulson@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */

namespace App\Http\Controllers\Admin;

use App\Location;
use App\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\LocationsDataTable;
use CountryState;


/**
 * Locations Admin Controller
 *
 * @category Class
 * @package  Controllers
 * @author   Darren Poulson <darren.poulson@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */
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
        return $dataTable->render('admin.locations.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = CountryState::getCountries();
        rsort($countries);
        return view('admin.locations.create')->with('countries', $countries);
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
            'name' => 'required',
            'postcode' => 'required'
            ]
        );

        if ($request['postcode'] != "") {
            $address = str_replace(' ', '+', $request['postcode']).'+'.str_replace(' ', '+', $request['country']);
            $url = "https://maps.google.com/maps/api/geocode/json?key=".config('gmap.google_api_key')."&address=".$address."&sensor=false";
            $geocode=file_get_contents($url);
            $output= json_decode($geocode);
            $request['latitude'] = strval($output->results[0]->geometry->location->lat);
            $request['longitude'] = strval($output->results[0]->geometry->location->lng);
        } else {
            $request['latitude'] = "";
            $request['longitude'] = "";
        }

        try {
            $location = Location::create($request->all());
            toastr()->success('Location created successfully');
        } catch (\Illuminate\Database\QueryException $exception) {
            toastr()->error('Failed to create Location');
        }

        return redirect()->route('admin.locations.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Location $location
     * @return \Illuminate\Http\Response
     */
    public function edit(Location $location)
    {
        $countries = CountryState::getCountries();
        rsort($countries);
        return view('admin.locations.edit')->with(
            [
            'location' => $location,
            'countries' => $countries
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Location            $location
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Location $location)
    {
        $request->validate(
            [
            'name' => 'required',
            'postcode' => 'required',
            ]
        );

        if ($request['postcode'] != "") {
            $address = str_replace(' ', '+', $request['postcode']).'+'.str_replace(' ', '+', $request['country']);
            $url = "https://maps.google.com/maps/api/geocode/json?key=".config('gmap.google_api_key')."&address=".$address."&sensor=false";
            $geocode=file_get_contents($url);
            $output= json_decode($geocode);
            $request['latitude'] = strval($output->results[0]->geometry->location->lat);
            $request['longitude'] = strval($output->results[0]->geometry->location->lng);
        } else {
            $request['latitude'] = "";
            $request['longitude'] = "";
        }

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
     * @param  \App\Location $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location)
    {
        $location->delete();

        return redirect()->route('admin.locations.index')
            ->with('success', 'Location deleted successfully');
    }
}
