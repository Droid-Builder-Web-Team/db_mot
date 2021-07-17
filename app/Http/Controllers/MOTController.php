<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\MOT;
use Illuminate\Http\Request;

class MOTController extends Controller
{

    public function __construct()
    {
      $this->middleware('auth');
      $this->middleware('verified');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MOT  $mOT
     * @return \Illuminate\Http\Response
     */
    public function show(MOT $mot)
    {
	if ($mot->droid->users->contains(auth()->user()) || auth()->user()->can('View Droids'))
        {
            return view('mot.show', compact('mot'));
        } else
        {
            abort(403);
        }

    }

    public function json($id)
    {
	$mot = MOT::find($id);
	if ($mot->droid->users->contains(auth()->user()) || auth()->user()->can('View Droids'))
        {
		$data = [];
		foreach($mot->sections() as $section) {
			array_push($data, $mot->lines($section->id));
		}
	    return response()->json($mot->details());
        } else
        {
            abort(403);
        }
    }

}
