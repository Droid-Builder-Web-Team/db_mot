<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PartsRunExampleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $droidType = DB::table('droid_type')->insert([
            'name' => 'R2',
        ]);

        $bcRep = DB::table('bc_rep')->insert([
            'user_id' => 1
        ]);
    }
}
