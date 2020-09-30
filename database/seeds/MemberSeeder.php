<?php

use Illuminate\Database\Seeder;

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
