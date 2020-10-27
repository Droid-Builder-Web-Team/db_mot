<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('roles')->delete();

        \DB::table('roles')->insert(array (
            0 =>
            array (
                'id' => 2,
                'name' => 'Super Admin',
                'guard_name' => 'web',
            ),
            1 =>
            array (
                'id' => 3,
                'name' => 'Org Admin',
                'guard_name' => 'web',
            ),
            2 =>
            array (
                'id' => 4,
                'name' => 'Events Officer',
                'guard_name' => 'web',
            ),
            3 =>
            array (
                'id' => 5,
                'name' => 'MOT Officer',
                'guard_name' => 'web',
            ),
        ));


    }
}
