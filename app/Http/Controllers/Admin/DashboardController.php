<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use App\Droid;
use App\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Toastr;

class DashboardController extends Controller
{
    /**
     * __construct
     *
     * @return void
     */
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
        $users = User::all();
        $droids = Droid::all();
        $badges = DB::table('id_list')->get();
        $events = Event::whereDate('date', '>=', Carbon::now())
            ->orderBy('date', 'asc')
            ->get();
        return view(
            'admin.dashboard', compact(
                'users', 'droids', 'events', 'badges'
            )
        );
    }


}
