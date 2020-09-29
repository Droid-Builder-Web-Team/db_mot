<?php

use Illuminate\Database\Seeder;

class AchievementsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('achievements')->delete();
        
        \DB::table('achievements')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Faceplant',
                'description' => 'Your droid did that which we hope no droid will ever do, Faceplant!',
                'date_created' => '2018-08-09 01:36:03',
                'date_updated' => '2018-08-08 16:54:53',
                'image' => NULL,
                'icon' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Wedding',
                'description' => 'Your droid helped to make a special day even better.',
                'date_created' => '2018-08-09 01:36:03',
                'date_updated' => '2020-09-29 21:14:39',
                'image' => NULL,
                'icon' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Education',
                'description' => 'Your droid helped to educate people.',
                'date_created' => '2018-08-09 01:36:03',
                'date_updated' => '2018-12-04 02:48:08',
                'image' => NULL,
                'icon' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Bad Motivator',
                'description' => 'Much like R5, your droid released the magic smoke at an event.',
                'date_created' => '2018-08-09 01:36:03',
                'date_updated' => '2020-09-29 21:14:39',
                'image' => NULL,
                'icon' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Hospital',
                'description' => 'Your droid visited an unwell person in hospital and made them feel that little bit better',
                'date_created' => '2019-02-02 15:09:35',
                'date_updated' => '2019-02-02 15:09:35',
                'image' => NULL,
                'icon' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Screen Used',
                'description' => 'Your droid was used in an actual film',
                'date_created' => '2019-02-04 18:11:19',
                'date_updated' => '2019-02-04 18:11:19',
                'image' => NULL,
                'icon' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Official Droid Builder',
                'description' => 'You were officially hired to be a droid builder.',
                'date_created' => '2019-02-04 18:12:03',
                'date_updated' => '2019-02-04 18:12:03',
                'image' => NULL,
                'icon' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Ultimate Faceplant',
                'description' => 'Faceplanted someone elses droid',
                'date_created' => '2019-03-24 21:37:33',
                'date_updated' => '2019-03-24 21:37:33',
                'image' => NULL,
                'icon' => NULL,
            ),
            8 => 
            array (
                'id' => 12,
                'name' => 'Walk of Shame',
                'description' => 'Droid fails mid event and has to be pushed home.',
                'date_created' => '2019-03-24 21:45:40',
                'date_updated' => '2020-09-29 21:14:39',
                'image' => NULL,
                'icon' => NULL,
            ),
            9 => 
            array (
                'id' => 14,
                'name' => 'F@H',
                'description' => 'Folding@Home participant',
                'date_created' => '2020-04-26 00:20:42',
                'date_updated' => '2020-04-26 00:20:42',
                'image' => NULL,
                'icon' => NULL,
            ),
        ));
        
        
    }
}