<?php

namespace App\Http\Controllers\Admin;

use App\Club;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\DataTables\ClubsDataTable;

class ClubsController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
      $this->middleware('permission:Edit Clubs');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ClubsDataTable $dataTable)
    {
      return $dataTable->render('admin.clubs.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.clubs.create');
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

        $club = Club::create($request->all());
        Storage::makeDirectory('clubs/'.$club->id);

        return redirect()->route('admin.clubs.index')
                        ->with('success','Club created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Club  $club
     * @return \Illuminate\Http\Response
     */
    public function edit(Club $club)
    {
        return view('admin.clubs.edit')->with('club', $club);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Club  $club
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Club $club)
    {
        $request->validate([
            'name' => 'required'
        ]);


        $club->options()->saveMany($request->options);

        $club->update($request->all());

        return redirect()->route('admin.clubs.index')
                        ->with('success','Club updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Club  $club
     * @return \Illuminate\Http\Response
     */
    public function destroy(Club $club)
    {
        $club->delete();

        Storage::deleteDirectory('clubs/'.$club->id);
        return redirect()->route('admin.clubs.index')
                        ->with('success','Club deleted successfully');
    }

}
