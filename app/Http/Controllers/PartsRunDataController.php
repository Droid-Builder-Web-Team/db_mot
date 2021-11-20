<?php

namespace App\Http\Controllers;

use App\User;
use App\Club;
use App\Comment;
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
        $partsRunData = app(PartsRunData::class)
            ->with(['partsRunAd'])
            ->orderBy('updated_at', 'desc')
            ->get();

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
        // Check image - RH
        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'mimes:jpeg,bmp,png' // Only allow .jpg, .bmp and .png file types.
            ]);
        }

        // Parts Run Data - RH
        $partsRunData = app(PartsRunData::class)->create([
            'club_id' => $request->club_id,
            'user_id' => Auth::user()->id,
            'bc_rep_id' => $request->bc_rep_id,
            'status' => $request->status,
        ]);

        $partsRunData->save();

        // Save image - RH
        $partsRunImage = $request->image->store('parts-run/'.$partsRunData->id.'/');
        $partsRunImage = app(PartsRunImage::class)->create([
            'parts_run_data_id' => $partsRunData->id,
            'filename' => basename($partsRunImage),
            'filetype' => $request->file('image')->getMimeType()
        ]);

        // Instructions Upload - RH
        if(!is_null($request->instructions)) {
            $partsRunInstructions = $request->instructions->store('parts-run/'.$partsRunData->id.'/');
            $partsRunInstructions = app(Instructions::class)->create([
                'parts_run_data_id' => $partsRunData->id,
                'filename' => basename($partsRunInstructions),
                'filetype' => $request->file('instructions')->getMimeType()
            ]);
        } else {
            $partsRunInstructionUrl = $request->validate('instructions_url');
        }

        // Parts run data. To be created last - RH
        $partsRunAd = app(PartsRunAd::class)->create([
            'parts_run_data_id' => $partsRunData->id,
            'title' => $request->title,
            'description' => $request->description,
            'history' => $request->history,
            'price' => $request->price,
            'includes' => $request->includes,
            'location' => $request->location,
            'shipping_costs' => $request->shipping_costs,
            'instructions_url' => optional($partsRunInstructionUrl),
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
        $partsRunData = PartsRunData::where('id', $id)->get();

        foreach($partsRunData as $include) {
            $includesArray = explode(",", $include->partsRunAd->includes);
            $includes = implode(",", $includesArray); // Implode to return as a string when displaying update form - RH
        };

        foreach($partsRunData as $shippingCosts) {
            $shippingCostsArray = explode(",", $shippingCosts->partsRunAd->shipping_costs);
            $shipping = implode(",", $shippingCostsArray); // Implode to return as a string when displaying update form - RH
        };

        return view('part-runs.edit', [
            'partsRunData' => $partsRunData,
            'includes' => $includes,
            'shipping' => $shipping,
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
        $partsRunData = app(PartsRunData::class)->find($id);
        $data = $request->except(['_method', '_token']);
        // $partsRunData->update($data);

        $partsRunData->update([
            // 'club_id' => $request->club_id, - Commented out for now as problems when testing this - RH
            // 'bc_rep_id' => $request->bc_rep_id, - Commented out for now as problems when testing this - RH
            'club_id' => 1,
            'bc_rep_id' => 1,
            'status' => $request->status
        ]);

        $partsRunData->partsRunAd()->update([
            'title' => $request->title,
            'description' => $request->description,
            'history' => $request->history,
            'price' => $request->price,
            'includes' => $request->includes,
            'location' => $request->location,
            'shipping_costs' => $request->shipping_costs,
            'purchase_url' => $request->purchase_url,
            'contact_email' => $request->contact_email
        ]);

        return redirect()->route('part-runs.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PartsRunData  $partsRunData
     * @return \Illuminate\Http\Response
     */
    public function destroy(PartsRunData $partsRunData)
    {
        $partsRunData = app(PartsRunData::class)->find($partsRunData->id)->destroy();
        return back();
    }

    public function requestPartsRun(Request $request)
    {
        return "Request a Parts Run";
    }

    public function comment(Request $request, PartsRunData $partsrun)
    {

        $request->validate([
            'body' => 'required',
        ]);
        $comment = new Comment;
        $comment->body = $request->body;
        $comment->user_id = auth()->user()->id;

        if (auth()->user()->id ==  $partsrun->user_id && $request->broadcast == 'on')
        {
          foreach($partsrun->users as $user)
          {
            $user->notify(new PartsRunUpdated($event));
          }
          $comment->broadcast = true;
        }

        $result = $partsrun->comments()->save($comment);
        toastr()->success('Comment Added');
        return back();
    }

    public function interested(Request $request, PartsRunData $partsrun)
    {

        if (!$partsrun->partsRunAd->quantity < $partsrun->interested->count() && $request->interest == 'yes')
        {
          toastr()->error('Part Run Full');
          return back();
        }
        $user = auth()->user();
        $hasEntry = $user->parts_interested()->where('parts_run_data_id', $partsrun->id)->exists();
        $attributes = [
          'status' => $request->interest,
        ];
        if ($hasEntry)
            $result = $partsrun->is_interested()->updateExistingPivot($user, $attributes);
        else
            $result = $partsrun->is_interested()->save($user, $attributes);
        toastr()->success('Interest registered for Parts Run');
        return back();
    }
}
