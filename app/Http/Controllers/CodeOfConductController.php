<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class CodeOfConductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
    }


    public function index()
    {
        return view('codeofconduct');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::find($request->user_id);
        $user->update(
            [
            'accepted_coc' => 1
            ]
        );
        return redirect('event');
    }
}
