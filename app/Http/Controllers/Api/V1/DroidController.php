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
        $droids = Droid::where('public', 'Yes')
            ->select('id', 'name', 'notes', 'club_id')
            ->with(['club:id,name', 'users'])
            ->get();

        return $droids->map(function ($droid) {
            return [
                'id' => $droid->id,
                'name' => $droid->name,
                'description' => $droid->notes,
                'club' => $droid->club,
                'rarity' => $this->calculateRarity($droid),
            ];
        });
    }

    /**
     * Get details for a specific droid.
     */
    public function show($id)
    {
        $droid = Droid::with(['club:id,name', 'users'])->find($id);

        if (!$droid) {
            return response()->json(['message' => 'Droid not found'], 404);
        }

        return [
            'id' => $droid->id,
            'name' => $droid->name,
            'description' => $droid->notes,
            'club' => $droid->club,
            'type' => $droid->type,
            'style' => $droid->style,
            'rarity' => $this->calculateRarity($droid),
        ];
    }

    /**
     * Calculate rarity based on the owner's event frequency in the last year.
     */
    private function calculateRarity($droid)
    {
        $maxEvents = 0;
        
        foreach ($droid->users as $user) {
            $count = \DB::table('members_events')
                ->where('user_id', $user->id)
                ->where('status', 'yes')
                ->where('date_added', '>=', now()->subYear())
                ->count();
            
            if ($count > $maxEvents) {
                $maxEvents = $count;
            }
        }

        if ($maxEvents >= 10) return 'Common';
        if ($maxEvents >= 5)  return 'Uncommon';
        if ($maxEvents >= 2)  return 'Rare';
        return 'Legendary';
    }
}
