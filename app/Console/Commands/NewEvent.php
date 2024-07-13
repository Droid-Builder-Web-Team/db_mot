<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Event;
use App\User;
use App\Location;
use Carbon\Carbon;

class NewEvent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:newevent';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for new events and send out notifications';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $events = Event::where('created_at', '>', Carbon::now()->subDays(1)->toDateTimeString());
        foreach ($events as $event) {
            echo "Checking: ".$event->name;
            $users = User::where('active', 'on')->get();
            $location = Location::find($event->location_id);
            foreach ($users as $user) {
                if ($user->postcode != "") {
                    $distance = ($user->settings()->get('max_event_distance')) * 1609.344;
                    $origin = $user->postcode;
                    $destination = $location->postcode;
                    $url = 'https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&'.
                            'origins='.$origin.
                            '&destinations='.$destination.
                            '&key='.config('gmap.google_directions_key');
                    $json = json_decode(Http::get($url));
                    $meters = $json->rows[0]->elements[0]->distance->value;
                    if ($meters < $distance) {
                        $user->notify(new EventCreated($event));
                    }
                }
            }
        }
    }
}
