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
        try {
            $droids = Droid::where('public', 'Yes')
                ->select('id', 'name', 'notes', 'club_id')
                ->with('club:id,name')
                ->get();

            return $droids->map(function ($droid) {
                return [
                    'id' => $droid->id,
                    'name' => $droid->name,
                    'description' => $droid->notes,
                    'club' => $droid->club,
                    'image' => url('/droid_image/' . $droid->id . '/front'),
                ];
            });
        } catch (\Exception $e) {
            \Log::error('Droid Hunter API Error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
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

        return [
            'id' => $droid->id,
            'name' => $droid->name,
            'description' => $droid->notes,
            'club' => $droid->club,
            'image' => url('/droid_image/' . $droid->id . '/front'),
            'type' => $droid->type,
            'style' => $droid->style,
        ];
    }
}
