<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('permissions')->delete();

        \DB::table('permissions')->insert(array (
            0 =>
            array (
                'id' => 11,
                'name' => 'Edit Config',
                'guard_name' => 'web',
            ),
            1 =>
            array (
                'id' => 12,
                'name' => 'Edit PLI',
                'guard_name' => 'web',
            ),
            2 =>
            array (
                'id' => 13,
                'name' => 'Edit Droids',
                'guard_name' => 'web',
            ),
            3 =>
            array (
                'id' => 14,
                'name' => 'Edit Members',
                'guard_name' => 'web',
            ),
            4 =>
            array (
                'id' => 15,
                'name' => 'Edit Achievements',
                'guard_name' => 'web',
            ),
            5 =>
            array (
                'id' => 16,
                'name' => 'Edit Events',
                'guard_name' => 'web',
            ),
            6 =>
            array (
                'id' => 17,
                'name' => 'View Droids',
                'guard_name' => 'web',
            ),
            7 =>
            array (
                'id' => 18,
                'name' => 'View Members',
                'guard_name' => 'web',
            ),
            8 =>
            array (
                'id' => 19,
                'name' => 'View Map',
                'guard_name' => 'web',
            ),
            9 =>
            array (
                'id' => 20,
                'name' => 'Add MOT',
                'guard_name' => 'web',
            ),
            10 =>
            array (
                'id' => 21,
                'name' => 'Edit Clubs',
                'guard_name' => 'web',
            ),
            11 =>
            array (
                'id' => 22,
                'name' => 'Edit Permissions',
                'guard_name' => 'web',
            ),
            12 =>
            array (
                'id' => 23,
                'name' => 'BC Rep',
                'guard_name' => 'web',
            ),
        ));


    }
}
