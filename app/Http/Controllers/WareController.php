<?php

/**
 * Ware Controller
 * php version 7.4
 *
 * @category Controller
 * @package  Controllers
 * @author   Darren Poulson <darren.poulson@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */

namespace App\Http\Controllers;

use App\Models\Ware;
use App\User;
use Illuminate\Http\Request;

/**
 * WareController
 *
 * @category Class
 * @package  Controllers
 * @author   Darren Poulson <darren.poulson@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */
class WareController extends Controller
{
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {

        $wares = Ware::where('state', 1)
            ->OrderBy('updated_at', 'desc')
            ->get();
        $userwares = Ware::where('state', 1)
            ->where('user_id', auth()->user()->id)
            ->get();
        $oldwares = Ware::where('state', 0)
            ->OrderBy('updated_at')
            ->get();
        return view('ware.index', compact('wares', 'userwares', 'oldwares'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('ware.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate(
            [
            'title' => 'required',
            'type' => 'in:FS,WTB,FREE',
            'description' => 'required',
            ]
        );

        $request['user_id'] = auth()->user()->id;
        if (isset($request['showemail'])) {
            $request['showemail'] = 1;
        } else {
            $request['showemail'] = 0;
        }
        $linkify = new \Misd\Linkify\Linkify();
        $request['description'] = $linkify->process($request->description);
        try {
            $auction = Ware::create($request->all());
            flash()->addSuccess('Item listing created successfully');
        } catch (\Illuminate\Database\QueryException $exception) {
            flash()->addError('Failed to create Item Listing');
        }

        return redirect()->route('ware.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ware $ware
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Ware $ware)
    {
        return view('ware.show', compact('ware'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ware $ware
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Ware $ware)
    {
        if (!$ware->user->id == auth()->user()->id && !auth()->user()->can('Edit Marketplace')) {
            abort(403);
        }
        return view('ware.edit', compact('ware'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Ware         $ware
     * @return \Illuminate\Contracts\View\View
     */
    public function update(Request $request, Ware $ware)
    {
        if (!$ware->user->id == auth()->user()->id && !auth()->user()->can('Edit Marketplace')) {
            abort(403);
        }

        $validatedData = $request->validate(
            [
            'title' => 'required',
            'type' => 'in:FS,WTB,FREE',
            'description' => 'required',
            ]
        );


        $newware = $request->all();
        $linkify = new \Misd\Linkify\Linkify();
        $newware['description'] = $linkify->process($request->description);
        try {
            $ware->update($newware);
            flash()->addSuccess('Item updated successfully');
        } catch (\Illuminate\Database\QueryException $exception) {
            flash()->addError(
                'Failed to update Item'
            );
        }


        return view('ware.show', compact('ware'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ware $ware
     * @return \Illuminate\Contracts\View\View
     */
    public function destroy(Ware $ware)
    {

        if (!auth()->user()->can('Edit Marketplace')) {
            abort(403);
        }
        $ware->delete();

        return redirect()->route('ware.index')
            ->with('success', 'Item deleted successfully');
    }
}
