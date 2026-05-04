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
     * Increment commendations for a droid.
     */
    public function commend(Request $request, $id)
    {
        $secret = $request->header('X-Hunter-Secret');
        if (!$secret || $secret !== config('services.hunter_pwa.secret')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $droid = Droid::find($id);
        if (!$droid) {
            return response()->json(['message' => 'Droid not found'], 404);
        }

        $droid->timestamps = false;
        $droid->increment('commendations');

        return response()->json([
            'message' => 'Commendation recorded',
            'count' => $droid->commendations
        ]);
    }

    /**
     * Increment scan count for a droid.
     */
    public function reportScan(Request $request, $id)
    {
        $secret = $request->header('X-Hunter-Secret');
        if (!$secret || $secret !== config('services.hunter_pwa.secret')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $droid = Droid::find($id);
        if (!$droid) {
            return response()->json(['message' => 'Droid not found'], 404);
        }

        $droid->timestamps = false;
        $droid->increment('scan_count');

        return response()->json([
            'message' => 'Scan recorded',
            'count' => $droid->scan_count
        ]);
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
