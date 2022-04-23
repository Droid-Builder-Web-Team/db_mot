<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('types')->delete();

        \DB::table('types')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => '3d Printer',
            ),
            1 =>
            array (
                'id' => 2,
                'name' => 'CNC',
            ),
            2 =>
            array (
                'id' => 3,
                'name' => 'Laser Cutter',
            ),
        ));
    }
}
