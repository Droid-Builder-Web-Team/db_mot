<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Srmklive\PayPal\Services\ExpressCheckout;
use App\User;
use App\Notifications\PLIPaid;
use Carbon\Carbon;

class PaypalController extends Controller
{
    /**
     * Retrieve IPN Response From PayPal
     *
     * @param \Illuminate\Http\Request $request
     */
    public function postNotify(Request $request)
    {
        // Import the namespace Srmklive\PayPal\Services\ExpressCheckout first in your controller.
        $provider = new ExpressCheckout;

        $request->merge(['cmd' => '_notify-validate']);
        $post = $request->all();

        $fp = fopen('debug.txt', 'a');
        fwrite($fp, print_r($post, true));
        $response = (string) $provider->verifyIPN($post);
        fwrite($fp, print_r($response, true));

        if ($response === 'VERIFIED') {
            $user = User::find($post['custom']);
            $user->update([ 'pli_date' => Carbon::today()->format('Y-m-d')]);
            $user->notify(new PLIPaid($user));
        }
        $admins = User::has('roles')->whereHas(
            "permissions", function ($q) {
                $q->where("name", "Add MOT"); 
            }
        )->get();
        foreach($admins as $admin)
        {
            $admin->notify(new PLIPaidAdmin($user));
        }

        fclose($fp);
    }
}
