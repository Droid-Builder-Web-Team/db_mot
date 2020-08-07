<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
      /*
        $perms['edit_config']   = Permission::create(['name' => 'Edit Config']);
        $perms['edit_pli']      = Permission::create(['name' => 'Edit PLI']);
        $perms['edit_droids']   = Permission::create(['name' => 'Edit Droids']);
        $perms['edit_members']  = Permission::create(['name' => 'Edit Members']);
        $perms['edit_achieve']  = Permission::create(['name' => 'Edit Achievements']);
        $perms['edit_events']   = Permission::create(['name' => 'Edit Events']);
        $perms['view_droids']   = Permission::create(['name' => 'View Droids']);
        $perms['view_members']  = Permission::create(['name' => 'View Members']);
        $perms['view_map']      = Permission::create(['name' => 'View Map']);
        $perms['add_mot']       = Permission::create(['name' => 'Add MOT']);

        $role = Role::create(['name'=>'Super Admin']);
        foreach($perms as $perm) {
          $role->givePermissionTo($perm);
        }
        $role = Role::create(['name'=>'Org Admin']);
        $role->givePermissionTo($perms['edit_droids']);
        $role->givePermissionTo($perms['edit_members']);
        $role->givePermissionTo($perms['edit_achieve']);
        $role->givePermissionTo($perms['edit_events']);
        $role->givePermissionTo($perms['view_droids']);
        $role->givePermissionTo($perms['view_members']);
        $role->givePermissionTo($perms['add_mot']);

        $role = Role::create(['name'=>'Events Officer']);
        $role->givePermissionTo($perms['edit_events']);

        $role = Role::create(['name'=>'MOT Officer']);
        $role->givePermissionTo($perms['add_mot']);
        $role->givePermissionTo($perms['edit_droids']);
        $role->givePermissionTo($perms['view_members']);
        $role->givePermissionTo($perms['view_droids']);
*/


        return view('home');
    }
}
