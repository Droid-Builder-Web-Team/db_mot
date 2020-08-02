<?php

namespace App\Http\Controllers;

use App\Droid_Users;
use App\Droid;
use App\User;

use Illuminate\Http\Request;

class DroidsUsersController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth');
  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $user = auth()->user();

        $my_droids = DB::table('droid_members')
            ->join('droids', 'droid_uid', '=', 'droids.droid_uid')
            ->select('droid_members.member_uid', 'droids.name', 'droids.droid_uid')
            ->where('droid_user.user_id', '=', $user->member_uid)
            ->get();


        return view('droids.user.index', [
            'my_droids' => $my_droids,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Droid_Users  $droid_Users
     * @return \Illuminate\Http\Response
     */
    public function show(Droid_Users $droid_Users)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Droid_Users  $droid_Users
     * @return \Illuminate\Http\Response
     */
    public function edit(Droid_Users $droid_Users)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Droid_Users  $droid_Users
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Droid_Users $droid_Users)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Droid_Users  $droid_Users
     * @return \Illuminate\Http\Response
     */
    public function destroy(Droid_Users $droid_Users)
    {
        //
    }
}
