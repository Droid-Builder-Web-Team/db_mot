<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('materials')->delete();

        \DB::table('materials')->insert(
            array (
            0 =>
            array (
                'id' => 1,
                'name' => 'PETG',
            ),
            1 =>
            array (
                'id' => 2,
                'name' => 'PLA',
            ),
            2 =>
            array (
                'id' => 3,
                'name' => 'TPU',
            ),
            3 =>
            array (
                'id' => 4,
                'name' => 'ABS',
            ),
            4 =>
            array (
                'id' => 5,
                'name' => 'Ply',
            ),
            5 =>
            array (
                'id' => 63,
                'name' => 'Aluminium',
            ),
            )
        );
    }
}
