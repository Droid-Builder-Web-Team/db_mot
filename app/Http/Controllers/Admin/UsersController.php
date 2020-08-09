<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use App\Droid;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:View Members');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (auth()->user()->cannot('View Members')) {
            abort(403);
        }
        $users = User::latest()->paginate(15);

        return view('admin.users.index', compact('users'))
          ->with('i', (request()->input('page', 1) -1) *15);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {

        if (auth()->user()->cannot('Edit Members')) {
            abort(403);
        }
        $roles = Role::all();
        return view('admin.users.edit')->with([
          'user' => $user,
          'roles' => $roles,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if (auth()->user()->can('Edit Permissions')) {
            $user->syncRoles($request->roles);
        } else {
            abort(403);
        }

        if (auth()->user()->cannot('Edit Members')) {
            abort(403);
        }
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $user->update($request->all());

        return redirect()->route('admin.users.index')
                        ->with('success','User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
