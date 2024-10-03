<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\Location;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class EventApiController extends Controller
{
    public function getFutureAllPublicEvents()
    {

        $data = array();
        $events = Event::where('public', '1')
            ->whereDate('date', '>=', Carbon::now())
            ->get();
        foreach ($events as $event) {
            if ($event->going()->count() > 0) {
                $tmp = array();
                $location = Location::find($event->location)->last();
                $tmp['id'] = $event->id;
                $tmp['name'] = $event->name;
                $tmp['date'] = $event->date;
                $tmp['url'] = $event->url;
                $tmp['location'] = $event->location;

                $data[] = $tmp;
            }
        }
        return response()->json($data);
    }

    public function getCharityYtd($year = 0)
    {

        if ($year == 0) {
            $year = date('Y');
        }
        $events = Event::whereYear('date', $year)->get();
        $charity = 0;
        foreach ($events as $event) {
            $charity += $event->charity_raised;
        }
        return response($charity, 200);
    }

    public function showimage($event_id)
    {
        $filePath = 'events/'.$event_id.'/event_image.jpg';

        $file = Storage::get($filePath);
        $type = Storage::mimeType($filePath);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }
}
