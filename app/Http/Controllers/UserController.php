<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;


class UserController extends Controller
{

    public function __construct()
    {
      $this->middleware('auth');
      //$this->middleware('permission:View members');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect('user/'.auth()->user()->member_uid);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        if ($user->member_uid !== auth()->user()->member_uid && auth()->user()->cannot('View Members'))
        {
            abort(403);
        }
        return view('user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if ($user->member_uid !== auth()->user()->member_uid && auth()->user()->cannot('Edit Members'))
        {
            abort(403);
        }
        return view('user.edit')->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if ($user->member_uid !== auth()->user()->member_uid && auth()->user()->cannot('Edit Members'))
        {
            abort(403);
        }
        $request->validate([
            'forename' => 'required',
            'surname' => 'required',
            'email' => 'required',
        ]);

        $user->update($request->all());

        return redirect()->route('user.show', auth()->user()->member_uid)
                        ->with('success','Details updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ($user->member_uid !== auth()->user()->member_uid && auth()->user()->cannot('Edit Members'))
        {
            abort(403);
        }
    }

    public function id(Request $id)
    {
        $user = User::where('badge_id', $id->id)->first();
        $path = 'members/'.$user->member_uid.'/mug_shot.jpg';
        $badge_data['name'] = $user->forename." ".$user->surname;
        $badge_data['mot'] = $user->validPLI();
        $badge_data['imageData'] = Storage::get($path);
        return view('user.id', compact('badge_data'));
    }

    public function displayMugShot($uid)
    {
        $path = 'members/'.$uid.'/mug_shot.jpg';
        if (!Storage::exists($path)) {
            $path = getcwd().'/img/blank_mug_shot.jpg';
            $file = file_get_contents($path);
            $type = "image/jpeg";
        } else {
            $file = Storage::get($path);
            $type = Storage::mimeType($path);
        }
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }

    public function displayQRCode($uid)
    {
        $path = 'members/'.$uid.'/qr_code.jpg';
        $file = Storage::get($path);
        $type = Storage::mimeType($path);
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }
}
