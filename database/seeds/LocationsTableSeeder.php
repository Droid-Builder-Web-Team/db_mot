<?php

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
                'created_at' => '2020-08-11 22:06:39',
                'updated_at' => '2020-08-11 22:30:28',
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
                'created_at' => '2020-08-12 20:30:28',
                'updated_at' => '2020-08-12 20:30:28',
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
                'created_at' => '2020-08-12 20:31:13',
                'updated_at' => '2020-08-12 20:31:13',
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
                'created_at' => '2020-08-12 20:32:16',
                'updated_at' => '2020-08-12 20:32:16',
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
                'created_at' => '2020-08-12 20:33:03',
                'updated_at' => '2020-08-12 20:33:03',
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
                'created_at' => '2020-08-12 20:34:52',
                'updated_at' => '2020-08-12 20:34:52',
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
                'created_at' => '2020-08-12 20:37:41',
                'updated_at' => '2020-08-12 20:37:41',
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
                'created_at' => '2020-08-12 20:38:23',
                'updated_at' => '2020-08-12 20:38:23',
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
                'created_at' => '2020-08-19 00:06:38',
                'updated_at' => '2020-08-19 00:06:38',
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
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
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
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ),
        ));
        
        
    }
}