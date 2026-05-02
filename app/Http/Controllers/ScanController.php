<?php

namespace App\Http\Controllers;

use App\Droid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class ScanController extends Controller
{
    /**
     * Handle the scan redirect from a physical tag.
     */
    public function redirect($id)
    {
        $droid = Droid::find($id);

        if (!$droid) {
            abort(404, 'Droid not found');
        }

        // Generate a signed URL for the Hunter PWA.
        // We'll need to define the PWA URL in the .env.
        $pwaUrl = config('services.hunter_pwa.url', 'http://localhost:8000');
        
        // Use temporarySignedRoute to create a link that expires.
        // Since we are in a separate app, we might need to manually build the signature
        // if we want the PWA to validate it using the same key.
        // BUT, a better way is to just pass a token that the PWA can then verify via API.
        
        // For now, let's just generate a simple signed URL redirect.
        // Note: Both apps will need to share the same APP_KEY for this to work out-of-the-box,
        // or we use a shared secret.
        
        $signature = hash_hmac('sha256', $id, config('app.key'));
        
        return redirect()->away($pwaUrl . "/scan/" . $id . "?signature=" . $signature);
    }
}
