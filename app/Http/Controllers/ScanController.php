<?php

namespace App\Http\Controllers;

use App\Droid;
use App\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class ScanController extends Controller
{
    /**
     * Handle the scan redirect from a physical tag.
     */
    public function redirect($id, $hash = null)
    {
        // 1. Verify the tag signature
        $tagSecret = env('TAG_SECRET', 'changeme');
        $expectedHash = substr(hash_hmac('sha256', $id, $tagSecret), 0, 8);

        if ($hash !== $expectedHash) {
            abort(403, 'This tag signature is invalid.');
        }

        $droid = Droid::with('users')->find($id);

        if (!$droid) {
            abort(404, 'Droid not found.');
        }

        // --- TEST MODE BYPASS ---
        if (config('app.env') === 'local' || env('HUNTER_TEST_MODE') === true) {
            // Skip event check in local dev or if test mode is explicitly enabled
        } else {
            // 2. Find all events happening today
            $today = now()->startOfDay();
            $activeEvents = Event::where('date', '<=', $today)
                ->get()
                ->filter(function($event) use ($today) {
                    $endDate = \Carbon\Carbon::parse($event->date)->addDays($event->days - 1)->endOfDay();
                    return $today->lte($endDate);
                });

            if ($activeEvents->isEmpty()) {
                abort(403, 'There are no active events scheduled for today.');
            }

            // 3. Check if any owner of this droid is registered for any active event
            $ownerIds = $droid->users->pluck('id');
            $isAttending = \DB::table('members_events')
                ->whereIn('event_id', $activeEvents->pluck('id'))
                ->whereIn('user_id', $ownerIds)
                ->where('status', 'yes')
                ->exists();

            if (!$isAttending) {
                abort(403, 'This droid is not currently registered for any active event.');
            }
        }

        // Generate a signed URL for the Hunter PWA.
        // We'll need to define the PWA URL in the .env.
        $pwaUrl = config('services.hunter_pwa.url', 'http://localhost:8000');
        
        // Use temporarySignedRoute to create a link that expires.
        // Since we are in a separate app, we might need to manually build the signature
        // if we want the PWA to validate it using the same key.
        // BUT, a better way is to just pass a token that the PWA can then verify via API.
        
        // Use a dedicated shared secret for the signature to avoid sharing APP_KEY.
        $secret = config('services.hunter_pwa.secret');
        $signature = hash_hmac('sha256', $id, $secret);
        
        return redirect()->away($pwaUrl . "/scan/" . $id . "?signature=" . $signature);
    }
}
