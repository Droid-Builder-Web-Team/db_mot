<?php

namespace App\Http\Controllers;

use App\Instructions;
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
        $user = Auth::user();

            // Check if a part run with the exact title exists
        if(PartsRunAd::where('title', $request->title)->exists()) {
            return PartsRunAd::where('title', $request->title);
        } else {
            // Parts Run Data
            $partsRunData = app(PartsRunData::class)->create([
                'droid_type_id' => 1,
                'user_id' => $user->id,
                'bc_rep_id' => 1,
                'status' => 'Active',
            ]);

            // $partsRunData = app(PartsRunData::class)->create([
            //     'droid_type_id' => 1,
            //     'user_id' => $user->id,
            //     'bc_rep_id' => 1,
            //     'status' => 'Active',
            // ]);

            $partsRunData->save();

            // Image Upload
            $imageName = $request->image->extension();
            $request->image->move(public_path('/img/'), $imageName);

            $file_url = 'public/img/' . $imageName;
            $content = file_get_contents(base_path($file_url));

            $content = $content . "\r\n" . $imageName;
            file_put_contents(base_path($file_url), $content);
            $partRunAdImage = "/img/" . $imageName;



            // Instructions Upload
            // $validated = $request->validate([
            //     'instructions' => 'mimes:pdf,doc,docx,txt|max:2048'
            // ]);
            // dd($validated);

            // $fileName = time().'_'.$validated->getClientOriginalName();

            // if($request->file('instructions')) {
            //    $instructions = app(Instructions::class)->create([
            //         'title' => 'filename',
            //         'filepath' => 'filePath',
            //         'url' => 'fileUrl'
            //     ]);

            //     $instructions->save();
            // }

            // Parts run data. To be created last
            $partsRunAd = app(PartsRunAd::class)->create([
                'parts_run_data_id' => $partsRunData->id,
                'title' => $request->title,
                'description' => $request->description,
                'history' => $request->history,
                'price' => $request->price,
                'includes' => $request->includes,
                'image_url' => $partRunAdImage,
                'instructions_id' => 1,
                'location' => $request->location,
                'shipping_costs' => $request->shipping_costs,
                'purchase_url' => $request->purchase_url,
                'contact_email' => $request->contact_email,
            ]);

            $partsRunAd->save();

            return view('part-runs.list');
        }
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
