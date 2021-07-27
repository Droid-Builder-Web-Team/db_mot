<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use App\Droid;
use App\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Toastr;

class DashboardController extends Controller
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
        $users = User::all();
        $droids = Droid::all();
        $events = Event::whereDate('date', '>=', Carbon::now())
                  ->orderBy('date', 'asc')
                  ->get();
        return view('admin.dashboard', compact('users', 'droids', 'events'));
    }


}
