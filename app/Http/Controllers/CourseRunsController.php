<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CourseRun;

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

        return view('runs.index', compact('runs'));
    }

    public function show($id)
    {
        $run = CourseRun::where('id', $id)->first();
        return view('runs.show', compact('run'));
    }
}
