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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $auctions = Auction::all();

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
            'finish_time' => 'date',
            'timezone' => 'timezone',
            ]
        );
        try {
            $auction = Auction::create($request->all());
            toastr()->success('Auction created successfully');
        }   catch (\Illuminate\Database\QueryException $exception) {
            toastr()->error('Failed to create Auction');
        }

        return redirect()->route('auctions.index');

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Location $location Location to show
     *
     * @return \Illuminate\Http\Response
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
        if ($hasEntry) {
            $result = $auction->users()->updateExistingPivot($user, $attributes);
            toastr()->success('Bid amount updated');
        } else {
            $result = $auction->users()->save($user, $attributes);
            toastr()->success('Bid submitted');
        }
        return back();
    }

}

