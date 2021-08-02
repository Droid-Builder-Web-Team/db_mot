<?php
namespace Database\Seeders;

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
            ),
            1 =>
            array (
                'id' => 2,
                'name' => 'topps',
            ),
            2 =>
            array (
                'id' => 4,
                'name' => 'tier_two',
            ),
            3 =>
            array (
                'id' => 9,
                'name' => 'partruns',
            ),
        ));


    }
}
