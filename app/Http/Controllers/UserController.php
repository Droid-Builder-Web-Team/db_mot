<?php

namespace App\Http\Controllers;

use App\User;
use App\Achievement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use PDF;


class UserController extends Controller
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
        return redirect('user/'.auth()->user()->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        if ($user->id !== auth()->user()->id && auth()->user()->cannot('View Members'))
        {
            abort(403);
        }
        $achievements = Achievement::all();
        return view('user.show', compact('user', 'achievements'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if ($user->id !== auth()->user()->id && auth()->user()->cannot('Edit Members'))
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
        if ($user->id !== auth()->user()->id && auth()->user()->cannot('Edit Members'))
        {
            abort(403);
        }
        $request->validate([
            'forename' => 'required',
            'surname' => 'required',
        ]);

        if ($request['postcode'] != "")
        {
            $address = str_replace(' ','+',$request['postcode']);
            $url = "https://maps.google.com/maps/api/geocode/json?key=".config('gmap.google_api_key')."&address=".$address."&sensor=false";
            $geocode=file_get_contents($url);
            $output= json_decode($geocode);
            $request['latitude'] = strval($output->results[0]->geometry->location->lat);
            $request['longitude'] = strval($output->results[0]->geometry->location->lng);
        } else {
            $request['latitude'] = "";
            $request['longitude'] = "";
        }

        try {
          $user->update($request->all());
          toastr()->success('User updated successfully');
        } catch (\Illuminate\Database\QueryException $exception) {
          toastr()->error('Failed to update User');
        }

        return redirect()->route('user.show', auth()->user()->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ($user->id !== auth()->user()->id && auth()->user()->cannot('Edit Members'))
        {
            abort(403);
        }
    }

    public function id(Request $id)
    {
        $user = User::where('badge_id', $id->id)->first();
        $path = 'members/'.$user->id.'/mug_shot.jpg';
        $badge_data['name'] = $user->forename." ".$user->surname;
        $badge_data['mot'] = $user->validPLI();
        $badge_data['imageData'] = Storage::get($path);
        return view('user.id', compact('badge_data'));
    }

    public function displayMugShot($uid, $size = '')
    {
        if ($size != "")
          $size = $size.'-';
        $path = 'members/'.$uid.'/'.$size.'mug_shot.png';
        if (!Storage::exists($path)) {
            $path = 'members/'.$uid.'/'.$size.'mug_shot.jpg';
        }
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
        $path = 'members/'.$uid.'/qr_code.png';
        if (!Storage::exists($path)) {
            $path = 'members/'.$uid.'/qr_code.jpg';
        }
        $file = Storage::get($path);
        $type = Storage::mimeType($path);
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }

    public function downloadPDF($id)
    {
        $user = User::find($id);
        $pdf = PDF::loadView('user.cover', compact('user'));
        //$pdf->defaultFont = 'Arial';

        return $pdf->download('cover_note.pdf');
      }

    public function edit_settings(User $user)
    {
        $settings = $user->settings()->all();
        return view('settings.edit', compact('settings'));
    }

    public function update_settings(Request $request, User $user)
    {

        foreach($request->input('notifications') as $notification => $value)
        {
          $user->settings()->update('notifications.'.$notification, $value);
        }
        $user->settings()->update('max_event_distance', $request->input('max_event_distance'));
        $user->settings()->update('date_format', $request->input('date_format'));
        $user->settings()->update('time_format', $request->input('time_format'));
        $user->settings()->update('timezone', $request->input('timezone'));
        toastr()->success('User settings updated successfully');
        return redirect()->route('settings.edit', auth()->user()->id);
    }
}
