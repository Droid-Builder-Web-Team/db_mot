<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

        $response = (string) $provider->verifyIPN($post);

        if ($response === 'VERIFIED') {
            $user = User::find($post['custom']);
            $user->update([ 'pli_date' => Carbon::today()->format('Y-m-d')]);
            $user->notify(new PLIPaid($user));

        }
    }
}
