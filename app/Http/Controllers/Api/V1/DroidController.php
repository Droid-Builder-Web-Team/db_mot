<?php

namespace App\Http\Controllers\Api\V1;

use App\Droid;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DroidController extends Controller
{
    /**
     * Get a list of all public droids.
     */
    public function index()
    {
        // For the hunter app, we only want to expose droids that are "public" or have a certain status.
        // For now, let's just return droids with their name and basic info.
        return Droid::select('id', 'name', 'description', 'image', 'club_id')
            ->with('club:id,name')
            ->get();
    }

    /**
     * Get details for a specific droid.
     */
    public function show($id)
    {
        $droid = Droid::with('club:id,name')->find($id);

        if (!$droid) {
            return response()->json(['message' => 'Droid not found'], 404);
        }

        return $droid;
    }
}
