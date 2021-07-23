<?php
namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Admin
        $this->call(MemberSeeder::class);

        // Parts Run Example - Disable in Production.
        $this->call(PartsRunExampleSeeder::class);

        // Seeders
        $this->call(AchievementsTableSeeder::class);
        $this->call(ClubOptionsTableSeeder::class);
        $this->call(ClubsTableSeeder::class);
        $this->call(ClubClubOptionsTableSeeder::class);
        $this->call(LocationsTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(RoleHasPermissionsTableSeeder::class);
    }
}
