<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Carbon\Carbon;
use App\Notifications\PLIPaid;

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
     * process transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function payPLI(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $response = $provider->createOrder([
            'intent'=> 'CAPTURE',
            'purchase_units'=> [[
                'reference_id' => 'PLIPaymentID'. auth()->user()->id,
                'amount'=> [
                  'currency_code'=> 'GBP',
                  'value'=> '25.00'
                ]
            ]],
            'application_context' => [
                 'cancel_url' => route('cancelTransaction'),
                 'return_url' => route('successTransaction')
            ]
        ]);
        return redirect($response['links'][1]['href'])->send();
    }
    /**
     * success transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function successTransaction(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);
        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            auth()->user()->update([ 'pli_date' => Carbon::today()->format('Y-m-d')]);
            auth()->user()->notify(new PLIPaid(auth()->user()));
            return redirect()
                ->route('user.show', auth()->user()->id)
                ->with('success', 'Transaction complete.');
        } else {
            return redirect()
                ->route('user.show', auth()->user()->id)
                ->with('error', $response['message'] ?? 'Something went wrong.');
        }
    }
    /**
     * cancel transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function cancelTransaction(Request $request)
    {
        return redirect()
            ->route('user.show', auth()->user()->id)
            ->with('error', $response['message'] ?? 'You have canceled the transaction.');
    }
}
