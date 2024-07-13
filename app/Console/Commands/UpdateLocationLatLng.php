<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Location;

class UpdateLocationLatLng extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:locations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update all locations with a postcode to contain lat/lng';

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
        $locations = Location::all();
        foreach($locations as $location) {
            if($location->postcode != "") {
                $address = str_replace(' ', '+', $location->postcode).'+'.str_replace(' ', '+', $location->country);
                $url = "https://maps.google.com/maps/api/geocode/json?key=".config('gmap.google_api_key')."&address=".$address."&sensor=false";
                $geocode = file_get_contents($url);
                $output = json_decode($geocode);
                $latitude = strval($output->results[0]->geometry->location->lat);
                $longitude = strval($output->results[0]->geometry->location->lng);
            } else {
                $latitude = "";
                $longitude = "";
            }
            $location->latitude = $latitude;
            $location->longitude = $longitude;
            $location->save();
        }
        return Command::SUCCESS;
    }
}
