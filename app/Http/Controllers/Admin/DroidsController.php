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
        $this->middleware('permission:View Droids');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(DroidsDataTable $dataTable)
    {
        //
        //$droids = Droid::orderBy('droid_uid', 'asc')->paginate(15);

        //return view('admin.droids.index', compact('droids'))
        //  ->with('i', (request()->input('page', 1) -1) *15);
        return $dataTable->render('admin.droids.index');
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
