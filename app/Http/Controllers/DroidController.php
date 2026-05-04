<?php

namespace App\Http\Controllers;

use App\Droid;
use App\MOT;
use App\Club;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\Validator;
use PDF;

class DroidController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['displayDroidImage']);
        $this->middleware('verified')->except(['displayDroidImage']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clubs = Club::all();
        return view('droid.create', compact('clubs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate(
            [
                'name' => 'required',
                'build_log' => 'url|nullable',
                'weight' => 'numeric|nullable',
                'build_type' => 'max:36'
            ]
        );

        try {
            $droid = Droid::create($request->all());
            flash()->addSuccess('Droid created successfully');
        } catch (\Illuminate\Database\QueryException $exception) {
            flash()->addError('Failed to create Droid');
        }

        try {
            $droid->users()->attach(auth()->user()->id);
            flash()->addSuccess('Droid attached to your account successfully');
        } catch (\Illuminate\Database\QueryException $exception) {
            flash()->addError('Failed to attach Droid');
        }

        return redirect()->route('user.show', auth()->user()->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Droid $droid
     * @return \Illuminate\Http\Response
     */
    public function show(Droid $droid)
    {
        if ($droid->users->contains(auth()->user()) || auth()->user()->can('View Droids')) {
            return view('droid.show', compact('droid'));
        } else {
            abort(403);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Droid $droid
     * @return \Illuminate\Http\Response
     */
    public function edit(Droid $droid)
    {
        $clubs = Club::all();
        if ($droid->users->contains(auth()->user()) || auth()->user()->can('Edit Droids')) {
            return view('droid.edit', compact('clubs'))->with('droid', $droid);
            ;
        } else {
            abort(403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Droid               $droid
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Droid $droid)
    {

        if (!$droid->users->contains(auth()->user()) && !auth()->user()->can('Edit Droids')) {
            abort(403);
        }

        $request->validate(
            [
                'name' => 'required',
                'build_log' => 'url|nullable',
                'weight' => 'numeric|nullable'
            ]
        );

        try {
            $droid->update($request->all());
            flash()->addSuccess('Droid updated successfully');
        } catch (\Illuminate\Database\QueryException $exception) {
            flash()->addError('Failed to update Droid');
        }
        return redirect()->route('droid.show', $droid->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Droid $droid
     * @return \Illuminate\Http\Response
     */
    public function destroy(Droid $droid)
    {

        if (!$droid->users->contains(auth()->user()) || !auth()->user()->can('Edit Droids')) {
            abort(403);
        }

        $users = $droid->users;
        foreach ($users as $user) {
            $droid->users()->detach($user->id);
        }
        $mots = $droid->mot;
        foreach ($mots as $mot) {
            $droid->mot()->delete();
        }
        $droid->delete();

        try {
            $droid->delete();
            flash()->addSuccess('Droid deleted successfully');
        } catch (\Illuminate\Database\QueryException $exception) {
            flash()->addError('Failed to delete Droid');
        }

        return redirect()->route('user.show', auth()->user()->id);
    }

    public function displayDroidImage(Request $request, $uid, $view, $size = '')
    {
        $droid = Droid::find($uid);
        
        if (!$droid) {
            abort(404);
        }
        
        // Secret Access for Hunter App
        $hunterSecret = $request->header('X-Hunter-Secret');
        $isHunter = $hunterSecret && $hunterSecret === config('services.hunter_pwa.secret');

        if (!$isHunter && (!auth()->check() || (!$droid->users->contains(auth()->user()) && !auth()->user()->can('View Droids')))) {
            if ($droid->public != "Yes") {
                abort(403);
            }
        }

        if ($size != "") {
            $size = $size . '-';
        }
        $path = 'droids/' . $uid . '/' . $size . '' . $view . '.png';
        if (!Storage::exists($path)) {
            $path = 'droids/' . $uid . '/' . $size . '' . $view . '.jpg';
        }

        $response = null;
        if (!Storage::exists($path)) {
            $localPath = public_path('img/blank_' . $view . '.jpg');
            if (file_exists($localPath)) {
                $response = response()->file($localPath);
            } else {
                // fallback if public_path doesn't find it
                $oldPath = getcwd() . '/img/blank_' . $view . '.jpg';
                if (file_exists($oldPath)) {
                    $response = response()->file($oldPath);
                } else {
                    abort(404);
                }
            }
        } else {
            // If using S3, generate a signed URL to offload the transfer to AWS
            if (config('filesystems.default') === 's3' || config('filesystems.cloud') === 's3') {
                $response = redirect()->away(Storage::temporaryUrl($path, now()->addMinutes(5)));
            } else {
                // Fallback for local development
                $file = Storage::get($path);
                $type = Storage::mimeType($path);
                $response = Response::make($file, 200)->header("Content-Type", $type);
            }
        }

        // Add CORS and Caching for Droid Hunter
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Methods', 'GET, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'X-Hunter-Secret, Origin, Content-Type, Accept');
        $response->headers->set('Cache-Control', 'public, max-age=31536000'); // Cache for 1 year

        return $response;
    }

    public function downloadPDF($id)
    {
        $droid = Droid::find($id);
        $user = User::find($droid->users->first()->id);
        $pdf = PDF::loadView('droid.info', compact('droid', 'user'));
        $pdf->defaultFont = 'Arial';
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('info_sheet_' . $droid->name . '.pdf');
    }

    public function togglePublic(Request $request)
    {

        $droid = Droid::find($request->id);
        if (!$droid->users->contains(auth()->user()) && !auth()->user()->can('Edit Droids')) {
            abort(403);
        }
        if ($request->mode == 'true') {
            $droid->public = 'Yes';
        } else {
            $droid->public = 'No';
        }
        $droid->save();
    }
}
