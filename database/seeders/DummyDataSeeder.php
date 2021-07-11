<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Faker\Provider\Lorem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // BC Rep as user_id 1
        $bcRep = DB::table('bc_rep')->insert([
            'user_id' => 1,
        ]);

        // Club Member
        $clubMember = DB::table('club_members')->insert([
            'user_id' => 1,
            'club_id' => 5,
        ]);

        $instructions = DB::table('instructions')->insert([
            'title' => 'Random Instruction 1',
            'filepath' => '',
            'url' => 'https://www.google.com',
        ]);

        $partRunData = DB::table('parts_run_data')->insert([
            'droid_type_id' => 1,
            'user_id' => 1,
            'bc_rep_id' => 1,
            'status' => 'Active',
            'parts_run_ad_id' => 1,
        ]);

        $partRunAd = DB::table('parts_run_ad')->insert([
            'title' => 'Lorum Ipsom',
            'description' => 'Anim non ullamco fugiat quis amet officia esse occaecat adipisicing nisi quis.',
            'history' => 'Adipisicing id velit sint in quis sunt aliqua cillum nisi et velit magna. Proident fugiat voluptate ad elit veniam exercitation consectetur cillum cillum. Commodo ullamco do voluptate consectetur Lorem aliquip labore commodo. Aute do exercitation et enim aute mollit eu quis occaecat mollit. Elit est Lorem pariatur sit mollit veniam aliquip pariatur elit sit amet non exercitation esse. Ex anim enim tempor sit occaecat qui nulla ullamco.',
            'price' => '100.00',
            'includes' => 'Reprehenderit labore elit fugiat ullamco nostrud enim Lorem laborum labore sit esse.',
            'instructions_id' => 1,
            'location' => 'Patricks House',
            'shipping_costs' => '103.94',
            'purchase_url' => 'https://www.google.com',
            'contact_email' => 'patrickstar@r2d2.com',
        ]);

        $mot = DB::table('mot')->insert([
            'droid_id' => 1,
            'date' => Carbon::now(),
            'location' => 'Naboo Brothel',
            'mot_type' => 'New',
            'approved' => 'Yes',
            'user' => 1
        ]);

        
    }
}