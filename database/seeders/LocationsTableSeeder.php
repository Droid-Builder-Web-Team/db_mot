<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LocationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('locations')->delete();

        \DB::table('locations')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => 'Birmingham NEC',
                'street' => 'North Ave',
                'town' => 'Marston Green',
                'county' => 'Birmingham',
                'postcode' => 'B40 1NT',
                'other_details' => 'xcvxcxv',
            ),
            1 =>
            array (
                'id' => 2,
                'name' => 'The Agincourt',
                'street' => 'London Road',
                'town' => 'York Town',
                'county' => 'Camberley',
                'postcode' => 'GU15 3JA',
                'other_details' => NULL,
            ),
            2 =>
            array (
                'id' => 3,
                'name' => 'Harper Adams University',
                'street' => NULL,
                'town' => 'Edgmond',
                'county' => 'Newport',
                'postcode' => 'TF10 8NB',
                'other_details' => NULL,
            ),
            3 =>
            array (
                'id' => 4,
                'name' => 'Manchester Arena',
                'street' => 'Victoria Station Approach',
                'town' => 'Hunts Bank',
                'county' => 'Manchester',
                'postcode' => 'M3 1AR',
                'other_details' => NULL,
            ),
            4 =>
            array (
                'id' => 5,
                'name' => 'Robin Park Leisure Center',
                'street' => 'Loire Drive',
                'town' => 'Newtown',
                'county' => 'Wigan',
                'postcode' => 'WN5 0UL',
                'other_details' => NULL,
            ),
            5 =>
            array (
                'id' => 6,
                'name' => 'Scarborough Spa',
                'street' => NULL,
                'town' => 'South Bay',
                'county' => 'Scarborough',
                'postcode' => 'YO11 2HD',
                'other_details' => NULL,
            ),
            6 =>
            array (
                'id' => 7,
                'name' => 'Manchester Central Convention Complex',
                'street' => 'Windmill Street',
                'town' => NULL,
                'county' => 'Manchester',
                'postcode' => 'M2 3GX',
                'other_details' => NULL,
            ),
            7 =>
            array (
                'id' => 8,
                'name' => 'Sandymoor Community Hall',
                'street' => 'Otterburn Street',
                'town' => NULL,
                'county' => 'Runcorn',
                'postcode' => 'WA7 1XU',
                'other_details' => NULL,
            ),
            8 =>
            array (
                'id' => 9,
                'name' => 'Humber Bridge',
                'street' => NULL,
                'town' => NULL,
                'county' => 'Humberside',
                'postcode' => 'HU13 0LN',
                'other_details' => NULL,
            ),
            9 =>
            array (
                'id' => 0,
                'name' => 'No Location',
                'street' => NULL,
                'town' => NULL,
                'county' => NULL,
                'postcode' => NULL,
                'other_details' => NULL,
            ),
            10 =>
            array (
                'id' => 12,
                'name' => 'Online',
                'street' => NULL,
                'town' => NULL,
                'county' => NULL,
                'postcode' => NULL,
                'other_details' => NULL,
            ),
        ));


    }
}
