<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator,Redirect,Response,File;
use Socialite;
use App\User;

class SocialController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {

        $getInfo = Socialite::driver($provider)->user();

        $user = $this->createUser($getInfo,$provider);

        auth()->login($user);

        return redirect()->to('/home');

    }
   function createUser($getInfo,$provider){

     $user = User::where('email', $getInfo->email)->first();

     if (!$user) {
        $id = User::generateID(60);
        $qr = User::generateQR($id, 90);
        list($forename, $surname) = explode(" ", $getInfo->name);
        $user = User::create([
            'forename'            => $forename,
            'surname'             => $surname,
            'email_verified_at'   => now(),
            'email'               => $getInfo->email,
        ]);
        $qr = User::generateQR($id, $user->id);
      }

      $user->update([
        'last_login' => now(),
        'last_login_from' => \Request::ip()
      ]);
      return $user;
   }
}
