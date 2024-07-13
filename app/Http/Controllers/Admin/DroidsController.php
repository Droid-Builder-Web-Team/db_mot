<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\DataTables\DroidsDataTable;
use App\Droid;
use App\User;
use App\Club;
use App\Comment;
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
     * @return \Illuminate\Contracts\View\View
     */
    public function create($id)
    {
        if (!auth()->user()->can('Edit Droids')) {
            abort(403);
        }
        $clubs = Club::all();
        $user = User::find($id);
        return view('admin.droids.create', compact('clubs', 'user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if (!auth()->user()->can('Edit Droids')) {
            abort(403);
        }
        $request->validate(
            [
            'name' => 'required'
            ]
        );

        try {
            $droid = Droid::create($request->except('user_id'));
            flash()->addSuccess('Droid created successfully');
        } catch (\Illuminate\Database\QueryException $exception) {
            flash()->addError('Failed to create Droid');
        }

        try {
            $droid->users()->attach($request->user_id);
            flash()->addSuccess('Droid attached to user ID '.$request->user_id.' successfully');
        } catch (\Illuminate\Database\QueryException $exception) {
            flash()->addError('Failed to attach Droid');
        }

        return redirect()->route('user.show', $request->user_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Droid $droid
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Droid $droid)
    {
        return view('droids.show', compact('droid'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Droid $droid
     * @return \Illuminate\Http\Response
     */
    public function edit(Droid $droid)
    {
        if (!auth()->user()->can('Edit Droids')) {
            abort(403);
        }
        $clubs = Club::all();
        return view('admin.droids.edit', compact('clubs'))->with('droid', $droid);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Droid               $droid
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Droid $droid)
    {
        if (!auth()->user()->can('Edit Droids')) {
            abort(403);
        }
        $request->validate(
            [
            'name' => 'required',
            ]
        );

        $droid->update($request->all());

        try {
            $droid->update($request->all());
            flash()->addSuccess('Droid updated successfully');
        } catch (\Illuminate\Database\QueryException $exception) {
            flash()->addError('Failed to update Droid');
        }

        return redirect()->route('droid.show', $droid->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Droid $droid
     * @return \Illuminate\Http\Response
     */
    public function destroy(Droid $droid)
    {
        $users = $droid->users;
        foreach ($users as $user) {
            $droid->users()->detach($user->id);
        }
        $mots = $droid->mot;
        foreach ($mots as $mot) {
            $droid->mot()->delete();
        }
        $droid->delete();

        try {
            $droid->delete();
            flash()->addSuccess('Droid deleted successfully');
        } catch (\Illuminate\Database\QueryException $exception) {
            flash()->addError('Failed to delete Droid');
        }

        return redirect()->route('admin.droids.index');
    }
}
