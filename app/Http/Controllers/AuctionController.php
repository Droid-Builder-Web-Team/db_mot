<?php

/**
 * Auction Controller
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
use App\Models\Auction;
use App\User;
use Carbon\Carbon;

/**
 * AuctionController
 *
 * @category Class
 * @package  Controllers
 * @author   Darren Poulson <darren.poulson@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */
class AuctionController extends Controller
{
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $auctions = Auction::all()
                    ->sortByDesc('finish_time');

        return view('auctions.index', compact('auctions'));
    }

    public function create()
    {
        return view('auctions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if (!auth()->user()->can('Edit Auction')) {
            abort(403);
        }


        $validatedData = $request->validate(
            [
            'title' => 'required',
            'type' => 'in:standard,silent',
            'currency' => 'in:gbp,usd',
            'country' => 'required',
            'finish_date' => 'date',
            'timezone' => 'timezone',
            ]
        );

        $request['finish_time'] = $request->finish_date . " " . $request->finish_time;
        try {
            $auction = Auction::create($request->all());
            flash()->addSuccess('Auction created successfully');
        } catch (\Illuminate\Database\QueryException $exception) {
            flash()->addError('Failed to create Auction');
        }

        return redirect()->route('auctions.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Location $location Location to show
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Auction $auction)
    {
        return view('auctions.show', compact('auction'));
    }


    public function bid(Request $request, Auction $auction)
    {
        $user = User::find($request->user_id);
        $hasEntry = $user->auctions()->where('auction_id', $auction->id)->exists();
        $attributes = [
          'amount' => $request->amount,
          'auction_id' => $auction->id
        ];

        if ($auction->secondsLeft() < 0) {
            flash()->addError('Auction has finished');
            return back();
        }

        if ($hasEntry) {
            $amount = $user->highestBid($auction);
            if ($amount > $request->amount) {
                flash()->addError('Lowering bid is not allowed');
                return back();
            }
        }
        $result = $auction->users()->save($user, $attributes);
        flash()->addSuccess('Bid submitted');
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Auction $auction Auction model to edit
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Auction $auction)
    {
        $auctions = Auction::all();
        return view(
            'auctions.edit'
        )->with('auction', $auction);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request Request data
     * @param \App\Event               $event   Event to update
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function update(Request $request, Auction $auction)
    {
        $validatedData = $request->validate(
            [
            'title' => 'required',
            'type' => 'in:standard,silent',
            'currency' => 'in:gbp,usd',
            'country' => 'required',
            'finish_date' => 'date',
            'timezone' => 'timezone',
            ]
        );


        $request['finish_time'] = $request->finish_date . " " . $request->finish_time;
        $newauction = $request->all();
        $linkify = new \Misd\Linkify\Linkify();
        $newauction['description'] = $linkify->process($request->description);
        try {
            $auction->update($newauction);
            flash()->addSuccess('Auction updated successfully');
        } catch (\Illuminate\Database\QueryException $exception) {
            flash()->addError(
                'Failed to update Auction'
            );
        }


        return view('auctions.show', compact('auction'));
    }
}
