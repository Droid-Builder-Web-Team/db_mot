<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $assets = Asset::where('current_state', '!=', 'RETIRED')
                ->OrderBy('updated_at')
                ->get();
        $userassets = Asset::where('user_id', auth()->user()->id)
                ->get();
        $oldassets = Asset::where('current_state', '=', 'RETIRED')
                ->OrderBy('updated_at')
                ->get();                    
        return view('asset.index', compact('assets', 'userassets', 'oldassets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Asset $asset)
    {
        return view('asset.show', compact('asset'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Asset $asset)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Asset $asset)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Asset $asset)
    {
        //
    }
}
