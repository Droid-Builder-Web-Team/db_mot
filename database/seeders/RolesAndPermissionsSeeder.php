<?php

/**
 * Seeder for permissions and roles
 * php version 7.4
 *
 * @category Seeder
 * @package  Seeders
 * @author   Darren Poulson <darren.poulson@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

/**
 * Roles and Permissions Seeder
 *
 * @category Class
 * @package  Seeders
 * @author   Darren Poulson <darren.poulson@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */
class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Create permissions and assign to roles
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]
            ->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'Edit Config']);
        Permission::create(['name' => 'Edit PLI']);
        Permission::create(['name' => 'Edit Droids']);
        Permission::create(['name' => 'Edit Members']);
        Permission::create(['name' => 'Edit Achievements']);
        Permission::create(['name' => 'Edit Events']);
        Permission::create(['name' => 'Edit Clubs']);
        Permission::create(['name' => 'Edit Permissions']);
        Permission::create(['name' => 'Edit Partrun']);
        Permission::create(['name' => 'Create Partrun']);

        Permission::create(['name' => 'View Droids']);
        Permission::create(['name' => 'View Members']);
        Permission::create(['name' => 'View Map']);
        Permission::create(['name' => 'Add MOT']);

        // create roles and assign created permissions

        // this can be done as separate statements
        $role = Role::create(['name' => 'Org Admin']);
        $role->givePermissionTo('Edit Droids');
        $role->givePermissionTo('Edit Members');
        $role->givePermissionTo('Edit Achievements');
        $role->givePermissionTo('Edit Events');
        $role->givePermissionTo('Edit Partrun');
        $role->givePermissionTo('View Members');
        $role->givePermissionTo('View Droids');
        $role->givePermissionTo('Edit PLI');

        // this can be done as separate statements
        $role = Role::create(['name' => 'Event Officer']);
        $role->givePermissionTo('Edit Events');

        // this can be done as separate statements
        $role = Role::create(['name' => 'MOT Officer']);
        $role->givePermissionTo('View Members');
        $role->givePermissionTo('Edit Droids');
        $role->givePermissionTo('Add MOT');

        // this can be done as separate statements
        $role = Role::create(['name' => 'Part Runner']);
        $role->givePermissionTo('Edit Partrun');

        // this can be done as separate statements
        $role = Role::create(['name' => 'BC Rep']);
        $role->givePermissionTo('Edit Partrun');
        $role->givePermissionTo('Create Partrun');

        $role = Role::create(['name' => 'Super Admin']);
        $role->givePermissionTo(Permission::all());
    }
}
