<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\MOT;
use App\Droid;
use Illuminate\Http\Request;

class MOTController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Droid $droid)
    {
        dd($droid); //->club->club_uid);
        return view('admin.mot.create');
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

}
