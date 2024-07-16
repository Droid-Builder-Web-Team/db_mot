<?php

/**
 * Portal News Controller
 * php version 7.4
 *
 * @category Controller
 * @package  Controllers
 * @author   Darren Poulson <darren.poulson@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */

namespace App\Http\Controllers;

use App\Http\Requests\StorePortalNewsRequest;
use App\Http\Requests\UpdatePortalNewsRequest;
use Illuminate\Support\Facades\Auth;
use App\PortalNews;
use App\User;

/**
 * PortalNewsController
 *
 * @category Class
 * @package  Controllers
 * @author   Darren Poulson <darren.poulson@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */
class PortalNewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $user->newnews = false;
        $user->save();
        $news = PortalNews::orderBy('created_at', 'desc')->get();
        return view('portalnews.index', compact('news'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('portalnews.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePortalNewsRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePortalNewsRequest $request)
    {
        $validatedData = $request->validated();

        try {
            $portalnews = PortalNews::create($validatedData);
            ;
            flash()->addSuccess('News created successfully');
        } catch (\Illuminate\Database\QueryException $exception) {
            flash()->addError('Failed to create News');
        }

        try {
            User::query()->update(['newnews' => 1 ]);
            flash()->addSuccess('Updated notification for all users');
        } catch (\Illuminate\Database\QueryException $exception) {
            flash()->addError('Failed to notify users');
        }
        return redirect()->route('portalnews.show', $portalnews->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PortalNews $portalnews
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = PortalNews::find($id);
        return view('portalnews.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PortalNews $portalnews
     * @return \Illuminate\Http\Response
     */
    public function edit(PortalNews $portalnews)
    {
        if (!Auth::user()->hasRole(['Super Admin', 'Org Admin'])) {
            abort(403);
        }
        return view('portalnews.edit', compact('portalnews'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePortalNewsRequest $request
     * @param  \App\PortalNews                            $portalNews
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePortalNewsRequest $request, PortalNews $portalnews)
    {
        $validatedData = $request->validated();

        try {
            $portalnews->update($validatedData);
            flash()->addSuccess('News updated successfully');
        } catch (\Illuminate\Database\QueryException $exception) {
            flash()->addError('Failed to update News');
        }
        return redirect()->route('portalnews.show', $portalnews->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PortalNews $portalnews
     * @return \Illuminate\Http\Response
     */
    public function destroy(PortalNews $portalnews)
    {

        if (!Auth::user()->hasRole(['Super Admin', 'Org Admin'])) {
            abort(403);
        }

        try {
            $portalnews->delete();
            flash()->addSuccess('News deleted successfully');
        } catch (\Illuminate\Database\QueryException $exception) {
            flash()->addError('Failed to delete news');
        }

        // Don't need to notify discord if event gets deleted.
        //$event->deletedEventNotification($event);
        return redirect()->route('portalnews.index');
    }
}
