<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CourseRun;
use Illuminate\Support\Facades\DB;

class CourseRunsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
    }

    public function index()
    {
        $runs = CourseRun::orderBy('final_time', 'asc')->get();
        // SELECT *, MIN(final_time) AS fastest_time FROM course_runs GROUP BY user_id ORDER BY fastest_time;

 //       $fastestTimes = CourseRun::selectRaw('
  //          * FROM course_runs WHERE final_time = ( SELECT MIN(final_time) FROM course_runs AS t2 WHERE t2.user_id = course_runs.user_id ORDER BY final_time ) ORDER BY course_runs.final_time ASC
//        ')->get();

        $fastestTimes = CourseRun::select("*")
            ->whereRaw('final_time = ( SELECT MIN(final_time) FROM course_runs AS t2 WHERE t2.user_id = course_runs.user_id ORDER BY final_time )')
            ->orderBy('final_time')
            ->get();
    
        //dd($fastestTimes);
        return view('runs.index', compact('fastestTimes'));
    }

    public function show($id)
    {
        $run = CourseRun::where('id', $id)->first();
        return view('runs.show', compact('run'));
    }
}
