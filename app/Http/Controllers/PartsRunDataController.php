<?php

namespace App\Http\Controllers;

use App\PartsRunAd;
use App\PartsRunData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StorePartsRunRequest;

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
        // dd($partsRunData);
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
        return view('part-runs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        // $validated = collect($request->validated());

        $user = Auth::user();

        if(PartsRunAd::where('title', $request->title)->exists()) {
            return PartsRunAd::where('title', $request->title);
        } else {
            $partsRunData = app(PartsRunData::class)->create([
                'droid_type_id' => 1,
                'user_id' => $user->id,
                'bc_rep_id' => 1,
                'status' => 'Active',
            ]);
            $partsRunData->save();

            $partsRunAd = new PartsRunAd;
            $partsRunAd->parts_run_data_id = $partsRunData->id;
            $partsRunAd->title = $request->title;
            $partsRunAd->description = $request->description;
            $partsRunAd->history = $request->history;
            $partsRunAd->price = $request->price;
            $partsRunAd->includes = $request->includes;
            $partsRunAd->instructions_id = 1;
            $partsRunAd->location = $request->location;
            $partsRunAd->shipping_costs = $request->shipping_costs;
            $partsRunAd->purchase_url = $request->purchase_url;
            $partsRunAd->contact_email = $request->contact_email;
            // dd($partsRunAd);
            $partsRunAd->save();

        }

            return view('part-runs.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PartsRunData  $partsRunData
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $partsRunData = PartsRunData::where('id', $id)->with('partsRunAd')->get();
        foreach($partsRunData as $include) {
            $includesArray = explode(",", $include->partsRunAd->includes);
        };

        foreach($partsRunData as $shippingCosts) {
            $shippingCostsArray = explode(",", $shippingCosts->partsRunAd->shipping_costs);
        };

        return view('part-runs.show', [
            'partsRunData' => $partsRunData,
            'includesArray' => $includesArray,
            'shippingCostsArray' => $shippingCostsArray
        ]);
    }

    /**
     * Show the form for editing the specified resource.z
     *
     * @param  \App\PartsRunData  $partsRunData
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $partsRunData = PartsRunData::where('id', $id)->with('partsRunAd')->get();
        foreach($partsRunData as $include) {
            $includesArray = explode(",", $include->partsRunAd->includes);
        };

        foreach($partsRunData as $shippingCosts) {
            $shippingCostsArray = explode(",", $shippingCosts->partsRunAd->shipping_costs);
        };

        return view('part-runs.edit', [
            'partsRunData' => $partsRunData,
            'includesArray' => $includesArray,
            'shippingCostsArray' => $shippingCostsArray
        ]);    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PartsRunData  $partsRunData
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $partsRunData = PartsRunData::findOrFail($id)->with('partsRunAd');
        // $partsRunAd = PartsRunAd::findOrFail('parts_run_data_id', $id);
        $partsRunData->update($data);
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