<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Hash;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('members')->insert([
            'username' => 'RobHowdle',
            'email' => 'robhowdle94@gmail.com',
            'password' => Hash::make('Password1'),
        ]);
    }
}
