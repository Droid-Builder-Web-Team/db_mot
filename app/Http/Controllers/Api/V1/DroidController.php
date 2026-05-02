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
            ->with(['club:id,name', 'users'])
            ->get();

        // Filter droids by owner activity (at least one owner attended an event in last 2 years)
        $activeDroids = $droids->filter(function ($droid) {
            foreach ($droid->users as $user) {
                $hasAttended = \DB::table('members_events')
                    ->join('events', 'members_events.event_id', '=', 'events.id')
                    ->where('members_events.user_id', $user->id)
                    ->where('members_events.status', 'yes')
                    ->where('events.date', '>=', now()->subYears(2))
                    ->exists();
                
                if ($hasAttended) {
                    return true;
                }
            }
            return false;
        });

        return $activeDroids->map(function ($droid) {
            $owner = $droid->users->first();
            return [
                'id' => $droid->id,
                'name' => $droid->name,
                'description' => $droid->notes,
                'back_story' => $droid->back_story,
                'club' => $droid->club,
                'rarity' => $this->calculateRarity($droid),
                'specs' => [
                    'weight' => $droid->weight,
                    'top_speed' => $droid->top_speed,
                    'material' => $droid->material,
                ],
                'location' => [
                    'country' => $owner->country ?? 'Unknown',
                    'county' => $owner->county ?? 'Unknown',
                ]
            ];
        })->values();
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

        $owner = $droid->users->first();
        return [
            'id' => $droid->id,
            'name' => $droid->name,
            'description' => $droid->notes,
            'back_story' => $droid->back_story,
            'club' => $droid->club,
            'type' => $droid->type,
            'style' => $droid->style,
            'rarity' => $this->calculateRarity($droid),
            'specs' => [
                'weight' => $droid->weight,
                'top_speed' => $droid->top_speed,
                'material' => $droid->material,
            ],
            'location' => [
                'country' => $owner->country ?? 'Unknown',
                'county' => $owner->county ?? 'Unknown',
            ]
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
