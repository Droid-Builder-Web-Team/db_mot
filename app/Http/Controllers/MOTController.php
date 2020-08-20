<?php

namespace App\Http\Controllers;

use App\MOT;
use Illuminate\Http\Request;

class MOTController extends Controller
{
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
        return view('mot.show', compact('mot'));
    }

}
