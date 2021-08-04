<?php

namespace App\Http\Controllers;

use App\User;
use App\Club;
use App\PartsRunAd;
use App\Instructions;
use App\PartsRunData;
use App\PartsRunImage;
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
        $partsRunData = PartsRunData::with(['partsRunAd'])->get();

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
        $clubs = Club::all();

        return view('part-runs.create', [
            'clubs' => $clubs,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            $user = Auth::user();

            // Check image
            if ($request->hasFile('image')) {
                $request->validate([
                    'image' => 'mimes:jpeg,bmp,png' // Only allow .jpg, .bmp and .png file types.
                ]);
            }

            // Parts Run Data
            $partsRunData = app(PartsRunData::class)->create([
                'club_id' => $request->club_id,
                'user_id' => $user->id,
                'bc_rep_id' => $request->bc_rep_id,
                'status' => 'Active',
            ]);

            $partsRunData->save();

            // Save image
            $partsRunImage = $request->image->store('parts-run/'.$partsRunData->id.'/');
            $partsRunImage = app(PartsRunImage::class)->create([
                'parts_run_data_id' => $partsRunData->id,
                'filename' => basename($partsRunImage),
                'filetype' => $request->file('image')->getMimeType()
            ]);

            // Instructions Upload
            $partsRunInstructions = $request->instructions->store('parts-run/'.$partsRunData->id.'/');
            $partsRunInstructions = app(Instructions::class)->create([
                'parts_run_data_id' => $partsRunData->id,
                'filename' => basename($partsRunInstructions),
                'filetype' => $request->file('instructions')->getMimeType()

            ]);

            // Parts run data. To be created last
            $partsRunAd = app(PartsRunAd::class)->create([
                'parts_run_data_id' => $partsRunData->id,
                'title' => $request->title,
                'description' => $request->description,
                'history' => $request->history,
                'price' => $request->price,
                'includes' => $request->includes,
                'location' => $request->location,
                'shipping_costs' => $request->shipping_costs,
                'purchase_url' => $request->purchase_url,
                'contact_email' => $request->contact_email,
            ]);

            $partsRunAd->save();

            return redirect()->route('part-runs.index');
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
        // dd($partsRunData);
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
        $clubs = Club::all();
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
            'shippingCostsArray' => $shippingCostsArray,
            'clubs' => $clubs
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
