<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
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
