<?php

use Illuminate\Database\Seeder;

class ClubOptionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('club_options')->delete();
        
        \DB::table('club_options')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'mot',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '2020-09-26 23:24:26',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'topps',
                'created_at' => '2020-09-27 01:36:14',
                'updated_at' => '2020-09-27 01:36:14',
            ),
            2 => 
            array (
                'id' => 4,
                'name' => 'tier_two',
                'created_at' => '2020-09-27 01:36:14',
                'updated_at' => '2020-09-27 01:36:14',
            ),
        ));
        
        
    }
}