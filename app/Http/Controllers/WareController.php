<?php

/**
 * Ware Controller
 * php version 7.4
 *
 * @category Controller
 * @package  Controllers
 * @author   Darren Poulson <darren.poulson@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */

namespace App\Http\Controllers;

use App\Models\Ware;
use App\User;
use Illuminate\Http\Request;


/**
 * WareController
 *
 * @category Class
 * @package  Controllers
 * @author   Darren Poulson <darren.poulson@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */
class WareController extends Controller
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

        $wares = Ware::where('state', 1)
                    ->OrderBy('updated_at')
                    ->get();
        $userwares = Ware::where('state', 1)
                    ->where('user_id', auth()->user()->id)
                    ->get();
        return view('ware.index', compact('wares', 'userwares'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ware.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate(
            [
            'title' => 'required',
            'type' => 'in:FS,WTB,FREE',
            'description' => 'required',
            ]
        );

        $request['user_id'] = auth()->user()->id;
        if(isset($request['showemail'])) {
            $request['showemail'] = 1;
        } else {
            $request['showemail'] = 0;
        }
        try {
            $auction = Ware::create($request->all());
            toastr()->success('Item listing created successfully');
        }   catch (\Illuminate\Database\QueryException $exception) {
            dd($exception);
            toastr()->error('Failed to create Item Listing');
        }

        return redirect()->route('ware.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ware  $ware
     * @return \Illuminate\Http\Response
     */
    public function show(Ware $ware)
    {
        return view('ware.show', compact('ware'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ware  $ware
     * @return \Illuminate\Http\Response
     */
    public function edit(Ware $ware)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ware  $ware
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ware $ware)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ware  $ware
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ware $ware)
    {
        //
    }
}
