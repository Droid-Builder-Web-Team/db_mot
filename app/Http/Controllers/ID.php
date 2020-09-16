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
      $user = User::where('badge_id', $id)->first();

      $path = 'members/'.$user->id.'/240-mug_shot.png';
      if (!Storage::exists($path)) {
          $path = 'members/'.$user->id.'/240-mug_shot.jpg';
      }
      if (!Storage::exists($path)) {
          $path = getcwd().'/img/blank_mug_shot.jpg';
          $file = base64_encode(file_get_contents($path));
      } else {
          $file = base64_encode(Storage::get($path));
      }
      $badge_data['name'] = $user->forename." ".$user->surname;
      $badge_data['mot'] = $user->validPLI();
      $badge_data['imageData'] = $file;
      return view('user.id', compact('badge_data', 'file'));
    }
}
