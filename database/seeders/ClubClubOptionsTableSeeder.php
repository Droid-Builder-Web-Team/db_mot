<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ClubClubOptionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('club_club_options')->delete();

        \DB::table('club_club_options')->insert(
            array (
            0 =>
            array (
                'id' => 1,
                'club_id' => 1,
                'club_options_id' => 2,
            ),
            1 =>
            array (
                'id' => 2,
                'club_id' => 1,
                'club_options_id' => 1,
            ),
            2 =>
            array (
                'id' => 3,
                'club_id' => 1,
                'club_options_id' => 4,
            ),
            )
        );


    }
}
