<?php

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
                'created_at' => '2020-08-05 16:32:04',
                'updated_at' => '2020-08-05 16:32:04',
            ),
            1 => 
            array (
                'id' => 12,
                'name' => 'Edit PLI',
                'guard_name' => 'web',
                'created_at' => '2020-08-05 16:32:04',
                'updated_at' => '2020-08-05 16:32:04',
            ),
            2 => 
            array (
                'id' => 13,
                'name' => 'Edit Droids',
                'guard_name' => 'web',
                'created_at' => '2020-08-05 16:32:04',
                'updated_at' => '2020-08-05 16:32:04',
            ),
            3 => 
            array (
                'id' => 14,
                'name' => 'Edit Members',
                'guard_name' => 'web',
                'created_at' => '2020-08-05 16:32:04',
                'updated_at' => '2020-08-05 16:32:04',
            ),
            4 => 
            array (
                'id' => 15,
                'name' => 'Edit Achievements',
                'guard_name' => 'web',
                'created_at' => '2020-08-05 16:32:04',
                'updated_at' => '2020-08-05 16:32:04',
            ),
            5 => 
            array (
                'id' => 16,
                'name' => 'Edit Events',
                'guard_name' => 'web',
                'created_at' => '2020-08-05 16:32:04',
                'updated_at' => '2020-08-05 16:32:04',
            ),
            6 => 
            array (
                'id' => 17,
                'name' => 'View Droids',
                'guard_name' => 'web',
                'created_at' => '2020-08-05 16:32:04',
                'updated_at' => '2020-08-05 16:32:04',
            ),
            7 => 
            array (
                'id' => 18,
                'name' => 'View Members',
                'guard_name' => 'web',
                'created_at' => '2020-08-05 16:32:04',
                'updated_at' => '2020-08-05 16:32:04',
            ),
            8 => 
            array (
                'id' => 19,
                'name' => 'View Map',
                'guard_name' => 'web',
                'created_at' => '2020-08-05 16:32:04',
                'updated_at' => '2020-08-05 16:32:04',
            ),
            9 => 
            array (
                'id' => 20,
                'name' => 'Add MOT',
                'guard_name' => 'web',
                'created_at' => '2020-08-05 16:32:04',
                'updated_at' => '2020-08-05 16:32:04',
            ),
            10 => 
            array (
                'id' => 21,
                'name' => 'Edit Clubs',
                'guard_name' => 'web',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            11 => 
            array (
                'id' => 22,
                'name' => 'Edit Permissions',
                'guard_name' => 'web',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}