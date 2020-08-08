<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use App\Droid;
use App\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users = User::all();
        $droids = Droid::all();
        $events = Event::all()->where('date', '>=', Carbon::now());
        return view('admin.dashboard', compact('users', 'droids', 'events'));
    }


}
