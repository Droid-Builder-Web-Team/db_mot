<?php

namespace App\Http\Controllers\Admin;

use App\Achievement;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\DataTables\AchievementsDataTable;

class AchievementsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:Edit Achievements');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AchievementsDataTable $dataTable)
    {
        return $dataTable->render('admin.achievements.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.achievements.create');
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
            'description' => 'required',
            ]
        );

        try {
            Achievement::create($request->all());
            toastr()->success('Achievement created successfully');
        } catch (\Illuminate\Database\QueryException $exception) {
            toastr()->error('Failed to create Achievement');
        }

        return redirect()->route('admin.achievements.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Achievement $achievement
     * @return \Illuminate\Http\Response
     */
    public function edit(Achievement $achievement)
    {
        return view('admin.achievements.edit')->with('achievement', $achievement);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Achievement         $achievement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Achievement $achievement)
    {
        $request->validate(
            [
            'name' => 'required',
            'description' => 'required',
            ]
        );

        $achievement->update($request->all());

        return redirect()->route('admin.achievements.index')
            ->with('success', 'Achievement updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Achievement $achievement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Achievement $achievement)
    {
        $achievement->delete();

        return redirect()->route('admin.achievements.index')
            ->with('success', 'Achievement deleted successfully');
    }

    public function award(Request $request)
    {
        $user = User::find($request->user_id);
        $user->achievements()->attach(
            $request->achievement_id, [
                    'added_by' => auth()->user()->id,
                    'notes' => $request->notes
            ]
        );
        return back();
    }

}
