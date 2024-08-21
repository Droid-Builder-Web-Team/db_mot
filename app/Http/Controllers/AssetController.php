<?php
/**
 * Asset Controller
 * php version 7.4
 *
 * @category Controller
 * @package  Controllers
 * @author   Darren Poulson <darren.poulson@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */

namespace App\Http\Controllers;

use App\Http\Requests\AssetRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

/**
 * AssetController
 *
 * @category Class
 * @package  Controllers
 * @author   Darren Poulson <darren.poulson@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */
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
        return view('asset.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AssetRequest $request)
    {

        $validatedData = $request->validated();

        $validatedData['user_id'] = Auth::user()->id;
        $validatedData['current_holder_id'] = Auth::user()->id;
        $validatedData['added'] = Carbon::now();

        try {
            $asset = Asset::create($validatedData);
            flash()->addSuccess('Asset created successfully');
        } catch (\Illuminate\Database\QueryException $exception) {
            flash()->addError('Failed to create Asset');
        }

        return redirect()->route('asset.show', $asset->id);
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
        if (!Auth::user()->can('Edit Assets') && Auth::user()->id != $asset->user->id) {
            abort(403);
        }
        return view('asset.edit', compact('asset'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AssetRequest $request, Asset $asset)
    {
        $validatedData = $request->validated();

        try {
            $asset->update($validatedData);
            flash()->addSuccess('Asset updated successfully');
        } catch (\Illuminate\Database\QueryException $exception) {
            flash()->addError('Failed to update Asset');
        }
        return redirect()->route('asset.show', $asset->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Asset $asset)
    {

        if (!Auth::user()->hasRole(['Super Admin', 'Org Admin', 'Quartermaster'])) {
            abort(403);
        }

        try {
            $asset->delete();
            flash()->addSuccess('Asset deleted successfully');
        } catch (\Illuminate\Database\QueryException $exception) {
            flash()->addError('Failed to delete asset');
        }

        // Don't need to notify discord if event gets deleted.
        //$event->deletedEventNotification($event);
        return redirect()->route('asset.index');
    }
}
