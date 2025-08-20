<?php

namespace App\Http\Controllers;

use App\Models\Nomination;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\NominationRequest;
use Illuminate\Support\Facades\Auth;

class NominationController extends Controller
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
     */
    public function index()
    {

        if (!auth()->user()->can('Edit Nominations')) {
            return view('nominations.create');
        }

        $nominations = Nomination::all();

        return view('nominations.index', compact('nominations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all()->mapWithKeys(function ($user) {
            return [$user->id => $user->forename . ' ' . $user->surname];
        });
        return view('nominations.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NominationRequest $request)
    {

        $validatedData = $request->validated();

        $data['user_id'] = Auth::user()->id;
        $data['nominee_id'] = User::find($validatedData['nominee_id'])->id;
        $data['reason'] = $validatedData['reason'];

        try {
            $nomination = Nomination::create($data);
            flash()->addSuccess('Nomination created successfully');
        } catch (\Illuminate\Database\QueryException $exception) {
            flash()->addError('Failed to create Nomination');
        }

        return redirect()->route('user.show', Auth::user()->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Nomination $nomination)
    {
        if (!auth()->user()->can('Edit Nominations')) {
            abort(403);
        }

        if (auth()->user()->id == $nomination->nominee_id) {
            abort(403);
        }
        return view('nominations.show', compact('nomination'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Nomination $nomination)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Nomination $nomination)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Nomination $nomination)
    {
        if (!auth()->user()->can('Edit Nominations')) {
            abort(403);
        }

        try {
            $nomination->delete();
            flash()->addSuccess('Nomination deleted successfully');
        } catch (\Illuminate\Database\QueryException $exception) {
            flash()->addError('Failed to delete nomination');
        }

        // Don't need to notify discord if event gets deleted.
        //$event->deletedEventNotification($event);
        return redirect()->route('nominations.index');        
    }
}
