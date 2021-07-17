<?php
namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = DB::table('members')->insert([
            'forename' => 'Admin',
            'surname' => 'Istrator',
            'username' => 'Administrator',
            'email' => 'droidbuilderwebteam@gmail.com',
            'password' => Hash::make('Password1'),
            'email_verified_at' => Carbon::now(),
            'gdpr_accepted' => 1
        ]);

        $adminRole = DB::table('model_has_roles')->insert([
            'role_id' => 2,
            'model_type' => 'App\User',
            'model_id' => 1
        ]);
    }
}
