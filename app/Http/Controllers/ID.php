<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\User;

class ID extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($id)
    {
      dd($id);
      $user = User::where('badge_id', $id)->first();
      $path = 'members/'.$user->id.'/mug_shot.jpg';
      $badge_data['name'] = $user->forename." ".$user->surname;
      $badge_data['mot'] = $user->validPLI();
      $badge_data['imageData'] = Storage::get($path);
      return view('user.id', compact('badge_data'));
    }
}
