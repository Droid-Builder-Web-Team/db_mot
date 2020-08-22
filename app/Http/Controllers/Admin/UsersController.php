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
    public function index(Request $request)
    {

        if (auth()->user()->cannot('View Members')) {
            abort(403);
        }

        return view('admin.users.index');
    }

    /*
    AJAX request
    */
    public function getUsers(Request $request){

      ## Read value
      $draw = $request->get('draw');
      $start = $request->get("start");
      $rowperpage = $request->get("length"); // Rows display per page

      $columnIndex_arr = $request->get('order');
      $columnName_arr = $request->get('columns');
      $order_arr = $request->get('order');
      $search_arr = $request->get('search');

      $columnIndex = $columnIndex_arr[0]['column']; // Column index
      $columnName = $columnName_arr[$columnIndex]['data']; // Column name
      $columnSortOrder = $order_arr[0]['dir']; // asc or desc
      $searchValue = $search_arr['value']; // Search value

      // Total records
      $totalRecords = User::select('count(*) as allcount')->count();
      $totalRecordswithFilter = User::select('count(*) as allcount')
                  ->where('forename', 'like', '%' .$searchValue . '%')
                  ->orWhere('surname', 'like', '%' .$searchValue . '%')
                  ->count();

      // Fetch records
      $records = User::orderBy($columnName,$columnSortOrder)
        ->where('forename', 'like', '%' .$searchValue . '%')
        ->orWhere('surname', 'like', '%' .$searchValue . '%')
        ->select('*')
        ->skip($start)
        ->take($rowperpage)
        ->get();


      $data_arr = array();
      $sno = $start+1;
      foreach($records as $record){
         $member_uid = $record->member_uid;
         $forename = $record->forename;
         $surname = $record->surname;
         if ($record->validPLI()) {
            $pli = "Valid";
         } else {
            $pli = "Invalid PLI";
         }
         $droid_count = $record->droids()->count();
         $actions = "<form action=\"/admin/users/".$record->member_uid."\" method=\"POST\">
            <button type=\"submit\" class=\"btn btn-danger\">Delete</button>
          </form>";

         $data_arr[] = array(
           "member_uid" => $member_uid,
           "forename" => $forename,
           "surname" => $surname,
           "pli" => $pli,
           "droid_count" => $droid_count,
           "actions" => $actions
         );
      }

      $response = array(
         "draw" => intval($draw),
         "iTotalRecords" => $totalRecords,
         "iTotalDisplayRecords" => $totalRecordswithFilter,
         "aaData" => $data_arr
      );

      echo json_encode($response);
      exit;
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
