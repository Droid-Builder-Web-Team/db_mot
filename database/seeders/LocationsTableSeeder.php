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

        \DB::table('locations')->insert(
            array (
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
                'other_details' => null,
            ),
            2 =>
            array (
                'id' => 3,
                'name' => 'Harper Adams University',
                'street' => null,
                'town' => 'Edgmond',
                'county' => 'Newport',
                'postcode' => 'TF10 8NB',
                'other_details' => null,
            ),
            3 =>
            array (
                'id' => 4,
                'name' => 'Manchester Arena',
                'street' => 'Victoria Station Approach',
                'town' => 'Hunts Bank',
                'county' => 'Manchester',
                'postcode' => 'M3 1AR',
                'other_details' => null,
            ),
            4 =>
            array (
                'id' => 5,
                'name' => 'Robin Park Leisure Center',
                'street' => 'Loire Drive',
                'town' => 'Newtown',
                'county' => 'Wigan',
                'postcode' => 'WN5 0UL',
                'other_details' => null,
            ),
            5 =>
            array (
                'id' => 6,
                'name' => 'Scarborough Spa',
                'street' => null,
                'town' => 'South Bay',
                'county' => 'Scarborough',
                'postcode' => 'YO11 2HD',
                'other_details' => null,
            ),
            6 =>
            array (
                'id' => 7,
                'name' => 'Manchester Central Convention Complex',
                'street' => 'Windmill Street',
                'town' => null,
                'county' => 'Manchester',
                'postcode' => 'M2 3GX',
                'other_details' => null,
            ),
            7 =>
            array (
                'id' => 8,
                'name' => 'Sandymoor Community Hall',
                'street' => 'Otterburn Street',
                'town' => null,
                'county' => 'Runcorn',
                'postcode' => 'WA7 1XU',
                'other_details' => null,
            ),
            8 =>
            array (
                'id' => 9,
                'name' => 'Humber Bridge',
                'street' => null,
                'town' => null,
                'county' => 'Humberside',
                'postcode' => 'HU13 0LN',
                'other_details' => null,
            ),
            9 =>
            array (
                'id' => 0,
                'name' => 'No Location',
                'street' => null,
                'town' => null,
                'county' => null,
                'postcode' => null,
                'other_details' => null,
            ),
            10 =>
            array (
                'id' => 12,
                'name' => 'Online',
                'street' => null,
                'town' => null,
                'county' => null,
                'postcode' => null,
                'other_details' => null,
            ),
            )
        );


    }
}
