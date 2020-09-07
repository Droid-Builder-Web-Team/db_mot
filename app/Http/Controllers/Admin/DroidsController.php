<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\DataTables\DroidsDataTable;
use App\Droid;
use App\User;
use App\Club;
use Illuminate\Http\Request;

class DroidsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:View Droids|Edit Droids');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(DroidsDataTable $dataTable)
    {
        return $dataTable->render('admin.droids.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        if (!auth()->user()->can('Edit Droids'))
              abort(403);
        $clubs = Club::all();
        $user = User::find($id);
        return view('admin.droids.create', compact('clubs', 'user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if (!auth()->user()->can('Edit Droids'))
              abort(403);
        $request->validate([
            'name' => 'required'
        ]);

        $droid = Droid::create($request->except('user_id'));
        $droid->users()->attach($request->user_id);
        return redirect()->route('user.show', $request->user_id )
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
        if (!auth()->user()->can('Edit Droids'))
              abort(403);
        $clubs = Club::all();
        return view('admin.droids.edit', compact('clubs'))->with('droid', $droid);
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
        if (!auth()->user()->can('Edit Droids'))
              abort(403);
        $request->validate([
            'name' => 'required',
        ]);

        $droid->update($request->all());

        $notification = array(
            'message' => 'Droid updated successfully.',
            'alert-type' => 'success'
        );
        return redirect()->route('droid.show', $droid->id)
                        ->with($notification);
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
