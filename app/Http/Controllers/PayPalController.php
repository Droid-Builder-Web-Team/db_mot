<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Carbon\Carbon;
use App\Notifications\PLIPaid;

/**
 * Class PayPalController
 * Handles PayPal integration for Public Liability Insurance (PLI) payments.
 * Uses the Srmklive PayPal SDK to process transactions.
 */
class PayPalController extends Controller
{
    /**
     * create transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function createTransaction()
    {
        return view('transaction');
    }
    /**
     * Initializes a PayPal transaction for purchasing PLI.
     * Determines the appropriate cost (£10 for static, £20 for driving)
     * and redirects the user to PayPal for approval.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $type The requested level of PLI ('static' or 'driving')
     * @return \Illuminate\Http\RedirectResponse
     */
    public function payPLI(Request $request, $type = 'static')
    {
        $type = $request->input('type', $type);
        $amount = '10.00';
        if ($type === 'driving') {
            $has_mot = false;
            foreach (auth()->user()->droids as $droid) {
                if ($droid->club->hasOption('mot') && $droid->hasMOT() && !$droid->hasExpiringMOT()) {
                    $has_mot = true;
                    break;
                }
            }
            if ($has_mot) {
                $amount = '20.00';
            } else {
                return redirect()->route('user.show', auth()->user()->id)->with('error', 'You need an MOT\'d droid to purchase driving PLI.');
            }
        }

        session(['pli_type_pending' => $type === 'driving' ? 'Driving' : 'Static']);

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $response = $provider->createOrder([
            'intent'=> 'CAPTURE',
            'purchase_units'=> [[
                'reference_id' => 'PLIPaymentID'. auth()->user()->id,
                'description' => ($type === 'driving' ? 'Driving Droid' : 'Static / Spotter') . ' PLI Payment - ' . auth()->user()->forename . ' ' . auth()->user()->surname,
                'amount'=> [
                  'currency_code'=> 'GBP',
                  'value'=> $amount
                ]
            ]],
            'application_context' => [
                 'cancel_url' => route('cancelTransaction'),
                 'return_url' => route('successTransaction')
            ]
        ]);

        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }
        }

        return redirect()
            ->route('user.show', auth()->user()->id)
            ->with('error', $response['message'] ?? 'Something went wrong. Could not connect to PayPal.');
    }
    /**
     * Handles the successful return from PayPal after user approves the transaction.
     * Captures the payment, updates the user's PLI expiry date, and sends a notification.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function successTransaction(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);
        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            $user = auth()->user();
            if ($user->validPLI()) {
                $newDate = Carbon::parse($user->pli_date)->addYear()->format('Y-m-d');
            } else {
                $newDate = Carbon::today()->format('Y-m-d');
            }
            
            $pliLevel = session('pli_type_pending', 'Static');
            $user->update([ 'pli_date' => $newDate, 'pli_level' => $pliLevel ]);
            session()->forget('pli_type_pending');
            
            $user->notify(new PLIPaid($user));
            return redirect()
                ->route('user.show', $user->id)
                ->with('success', 'Transaction complete.');
        } else {
            return redirect()
                ->route('user.show', auth()->user()->id)
                ->with('error', $response['message'] ?? 'Something went wrong.');
        }
    }
    /**
     * Handles the scenario where a user cancels the PayPal transaction.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancelTransaction(Request $request)
    {
        return redirect()
            ->route('user.show', auth()->user()->id)
            ->with('error', 'You have canceled the transaction.');
    }
}
