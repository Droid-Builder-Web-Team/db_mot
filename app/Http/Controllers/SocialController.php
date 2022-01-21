<?php

/**
 * Socialite Login Controller
 * php version 7.4
 *
 * @category Controller
 * @package  Controllers
 * @author   Darren Poulson <darren.poulson@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator,Redirect,Response,File;
use Socialite;
use App\User;
use App\Notifications\NewUser;

/**
 * Achievements
 *
 * @category Class
 * @package  Controllers
 * @author   Darren Poulson <darren.poulson@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */
class SocialController extends Controller
{
    /**
     * Redirect to socialite provider
     *
     * @param mixed $provider Name of the provider
     *
     * @return void
     */
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Callback function for provider
     *
     * @param mixed $provider Name of provider
     *
     * @return void
     */
    public function callback($provider)
    {

        $getInfo = Socialite::driver($provider)->user();

        if ($getInfo->email == null) {
            toastr()->error('You must have an email registered with the account');
            return redirect()->to('/login');
        }

        $user = $this->createUser($getInfo, $provider);

        if ($user->active == "on") {
            try {
                $login = \Auth::login($user);
            } catch(Exception $e) {
                toastr()->error('Login error: ' . $e);
            }
        } else {
            toastr()->error('Account inactive');
            return redirect()->to('/login');
        }

        toastr()->success('Logging in');
        return redirect()->to('/user');

    }

    /**
     * Create User if they don't exist
     *
     * @param mixed $getInfo  Information provided by social provider
     * @param mixed $provider Name of provider
     *
     * @return void
     */
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
                'active'              => 'on',
                ]
            );
            $qr = User::generateQR($id, $user->id);
            $admins = User::whereHas(
                "roles", function ($q) {
                    $q->where("name", "Super Admin");
                }
            )->get();
            foreach ($admins as $admin) {
                  $admin->notify(new NewUser($user));
            }
        }

        $user->update(
            [
            'last_login' => now(),
            'last_login_from' => \Request::ip(),
            'last_login_type' => $provider
            ]
        );
        return $user;
    }
}
