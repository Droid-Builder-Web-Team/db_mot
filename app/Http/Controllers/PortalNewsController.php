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
        $user = auth()->user();
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
     * @param  \App\Http\Requests\StorePortalNewsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePortalNewsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PortalNews  $portalNews
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
     * @param  \App\PortalNews  $portalNews
     * @return \Illuminate\Http\Response
     */
    public function edit(PortalNews $portalNews)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePortalNewsRequest  $request
     * @param  \App\PortalNews  $portalNews
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePortalNewsRequest $request, PortalNews $portalNews)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PortalNews  $portalNews
     * @return \Illuminate\Http\Response
     */
    public function destroy(PortalNews $portalNews)
    {
        //
    }
}
