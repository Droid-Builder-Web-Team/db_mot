<?php

namespace App\Http\Controllers;

use App\Location;
use App\Comment;
use Illuminate\Http\Request;

class LocationController extends Controller
{

    public function __construct()
    {
      $this->middleware('auth');
      $this->middleware('verified');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show(Location $location)
    {
        return view('location.show', compact('location'));
    }

    public function comment(Request $request, Location $location)
    {

        $comment = new Comment;
        $comment->body = $request->body;
        $comment->user_id = auth()->user()->id;

        $result = $location->comments()->save($comment);

        return view('location.show', compact('location'));
    }

}
