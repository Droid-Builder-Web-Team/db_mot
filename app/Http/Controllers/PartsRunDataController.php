<?php

namespace App\Http\Controllers;

use App\PartsRunAd;
use App\PartsRunData;
use Illuminate\Http\Request;
class PartsRunDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $partsRunData = PartsRunData::with(['partsRunAd', 'droidType'])->get();

        return view('part-runs.list', [
            'partsRunData'=> $partsRunData,
        ]);
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
     * @param  \App\PartsRunData  $partsRunData
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $partsRun = PartsRunAd::where('id', $id)->with('partsRun')->get();
        return view('part-runs.show', [
            'partsRun' => $partsRun
        ]);
    }

    /**
     * Show the form for editing the specified resource.z
     *
     * @param  \App\PartsRunData  $partsRunData
     * @return \Illuminate\Http\Response
     */
    public function edit(PartsRunData $partsRunData)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PartsRunData  $partsRunData
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PartsRunData $partsRunData)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PartsRunData  $partsRunData
     * @return \Illuminate\Http\Response
     */
    public function destroy(PartsRunData $partsRunData)
    {
        //
    }

    public function requestPartsRun(Request $request)
    {
        return "Request a Parts Run";
    }
}