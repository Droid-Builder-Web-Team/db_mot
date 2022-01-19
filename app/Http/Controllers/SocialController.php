<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator,Redirect,Response,File;
use Socialite;
use App\User;
use App\Notifications\NewUser;


class SocialController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {

        $getInfo = Socialite::driver($provider)->user();

        if ($getInfo->email == null){
            toastr()->error('You must have an email registered with the account');
            return redirect()->to('/login');
        }

        $user = $this->createUser($getInfo, $provider);

        if ($user->active == "on") {
            auth()->login($user);
        }
        else
        {
            return redirect()->to('/login');
        }

        return redirect()->to('/user');

    }
    function createUser($getInfo,$provider)
    {

        $user = User::where('email', $getInfo->email)->first();

        if (!$user) {
            $id = User::generateID(60);
            $qr = User::generateQR($id, 90);
            list($forename, $surname) = explode(" ", $getInfo->name);
            $user = User::create(
                [
                'forename'            => $forename,
                'surname'             => $surname,
                'email_verified_at'   => now(),
                'email'               => $getInfo->email,
                'badge_id'            => $id,
                ]
            );
            $qr = User::generateQR($id, $user->id);
            $admins = User::whereHas(
                "roles", function ($q) {
                    $q->where("name", "Super Admin");
                }
            )->get();
            foreach($admins as $admin)
            {
                  $admin->notify(new NewUser($user));
            }
        }

        $user->update(
            [
            'last_login' => now(),
            'last_login_from' => \Request::ip()
            ]
        );
        return $user;
    }
}
