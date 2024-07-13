<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class ClubsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('clubs')->delete();
        DB::table('clubs')->insert(
            array (
            0 =>
            array (
                'id' => 1,
                'name' => 'UK R2 Builders',
                'website' => 'https://astromech.info',
                'facebook' => 'https://www.facebook.com/groups/UKR2D2Builders',
                'forum' => 'https://ukr2d2.proboards.com/forum',
            ),
            1 =>
            array (
                'id' => 2,
                'name' => '39.1%',
                'website' => null,
                'facebook' => null,
                'forum' => null,
            ),
            2 =>
            array (
                'id' => 3,
                'name' => 'UK BB-8 Builders',
                'website' => null,
                'facebook' => null,
                'forum' => null,
            ),
            3 =>
            array (
                'id' => 4,
                'name' => 'UK MSE-9 Builders',
                'website' => null,
                'facebook' => null,
                'forum' => null,
            ),
            4 =>
            array (
                'id' => 5,
                'name' => 'T3 Builders',
                'website' => 'https://www.t3buildersclub.co.uk/',
                'facebook' => 'https://www.facebook.com/groups/t3droidbuildersgroup',
                'forum' => 'https://t3builders.proboards.com/',
            ),
            5 =>
            array (
                'id' => 6,
                'name' => 'HO-15 Builders',
                'website' => null,
                'facebook' => 'https://www.facebook.com/groups/HO15BuildersGroup',
                'forum' => null,
            ),
            )
        );
    }
}
