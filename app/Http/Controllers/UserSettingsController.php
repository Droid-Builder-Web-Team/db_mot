<?php

namespace App\Http\Controllers;

use App\UserSetting;
use App\User;
use Illuminate\Http\Request;

class UserSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = auth()->user()->settings;
        foreach($settings as $setting){
          echo $setting;
        }
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
     * @param  \App\UserSetting  $userSetting
     * @return \Illuminate\Http\Response
     */
    public function show(UserSetting $userSetting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserSetting  $userSetting
     * @return \Illuminate\Http\Response
     */
    public function edit(UserSetting $userSetting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserSetting  $userSetting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserSetting $userSetting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserSetting  $userSetting
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserSetting $userSetting)
    {
        //
    }
}
