<?php

use Illuminate\Database\Seeder;

class ClubsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('clubs')->delete();
        
        \DB::table('clubs')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'UK R2 Builders',
                'website' => 'https://astromech.info',
                'facebook' => 'https://www.facebook.com/groups/UKR2D2Builders',
                'forum' => 'https://ukr2d2.proboards.com/forum',
                'created_at' => '2020-09-27 00:46:27',
                'updated_at' => '2020-09-27 00:36:27',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => '39.1%',
                'website' => NULL,
                'facebook' => NULL,
                'forum' => NULL,
                'created_at' => '2020-09-27 00:46:27',
                'updated_at' => '2020-09-27 00:46:27',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'UK BB-8 Builders',
                'website' => NULL,
                'facebook' => NULL,
                'forum' => NULL,
                'created_at' => '2020-09-27 00:47:31',
                'updated_at' => '2020-09-27 00:47:31',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'UK MSE-9 Builders',
                'website' => NULL,
                'facebook' => NULL,
                'forum' => NULL,
                'created_at' => '2020-09-27 00:47:31',
                'updated_at' => '2020-09-27 00:47:31',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'T3 Builders',
                'website' => NULL,
                'facebook' => NULL,
                'forum' => NULL,
                'created_at' => '2020-09-27 00:47:49',
                'updated_at' => '2020-09-27 00:47:49',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'HO-15 Builders',
                'website' => NULL,
                'facebook' => 'https://www.facebook.com/groups/HO15BuildersGroup',
                'forum' => NULL,
                'created_at' => '2020-09-27 01:08:24',
                'updated_at' => '2020-09-27 01:08:24',
            ),
        ));
        
        
    }
}