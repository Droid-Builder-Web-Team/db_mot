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
                'image' => NULL,
                'icon' => NULL,
            ),
            1 =>
            array (
                'id' => 2,
                'name' => 'Wedding',
                'description' => 'Your droid helped to make a special day even better.',
                'image' => NULL,
                'icon' => NULL,
            ),
            2 =>
            array (
                'id' => 3,
                'name' => 'Education',
                'description' => 'Your droid helped to educate people.',
                'image' => NULL,
                'icon' => NULL,
            ),
            3 =>
            array (
                'id' => 4,
                'name' => 'Bad Motivator',
                'description' => 'Much like R5, your droid released the magic smoke at an event.',
                'image' => NULL,
                'icon' => NULL,
            ),
            4 =>
            array (
                'id' => 5,
                'name' => 'Hospital',
                'description' => 'Your droid visited an unwell person in hospital and made them feel that little bit better',
                'image' => NULL,
                'icon' => NULL,
            ),
            5 =>
            array (
                'id' => 6,
                'name' => 'Screen Used',
                'description' => 'Your droid was used in an actual film',
                'image' => NULL,
                'icon' => NULL,
            ),
            6 =>
            array (
                'id' => 7,
                'name' => 'Official Droid Builder',
                'description' => 'You were officially hired to be a droid builder.',
                'image' => NULL,
                'icon' => NULL,
            ),
            7 =>
            array (
                'id' => 8,
                'name' => 'Ultimate Faceplant',
                'description' => 'Faceplanted someone elses droid',
                'image' => NULL,
                'icon' => NULL,
            ),
            8 =>
            array (
                'id' => 12,
                'name' => 'Walk of Shame',
                'description' => 'Droid fails mid event and has to be pushed home.',
                'image' => NULL,
                'icon' => NULL,
            ),
            9 =>
            array (
                'id' => 14,
                'name' => 'F@H',
                'description' => 'Folding@Home participant',
                'image' => NULL,
                'icon' => NULL,
            ),
        ));


    }
}
