<?php

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
                'created_at' => '2020-08-05 15:32:04',
                'updated_at' => '2020-08-05 15:32:04',
            ),
            1 => 
            array (
                'id' => 3,
                'name' => 'Org Admin',
                'guard_name' => 'web',
                'created_at' => '2020-08-05 15:32:04',
                'updated_at' => '2020-08-05 15:32:04',
            ),
            2 => 
            array (
                'id' => 4,
                'name' => 'Events Officer',
                'guard_name' => 'web',
                'created_at' => '2020-08-05 15:32:04',
                'updated_at' => '2020-08-05 15:32:04',
            ),
            3 => 
            array (
                'id' => 5,
                'name' => 'MOT Officer',
                'guard_name' => 'web',
                'created_at' => '2020-08-05 15:32:04',
                'updated_at' => '2020-08-05 15:32:04',
            ),
        ));
        
        
    }
}