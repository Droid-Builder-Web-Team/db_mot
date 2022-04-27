<?php

namespace App\Http\Middleware;

use App\Event;
use App\PartsRunData;
use Closure;
use Illuminate\Support\Facades\Route;

class RedirectCrawlers
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $crawlers = [
            'facebookexternalhit/1.1',
            'facebookexternalhit/1.1 (+http://www.facebook.com/externalhit_uatext.php)',
            'Facebot',
            'Twitterbot',
        ];

        $userAgent = $request->header('User-Agent');

        if (in_array($userAgent, $crawlers)) {
            switch (Route::currentRouteName()) {
            case "event.show":
                list($id) = sscanf($request->path(), 'event/%d');

                $event = Event::where('id', $id)->first();
                return view('event.facebook', compact('event'));
                break;
            case "parts-run.show":
                list($id) = sscanf($request->path(), 'parts-run/%d');

                $partsRunData = PartsRunData::where('id', $id)->with('partsRunAd')->get();
                return view('parts-run.facebook', compact('partsRunData'));
                break;
            }
        }
        return $next($request);
    }
}
