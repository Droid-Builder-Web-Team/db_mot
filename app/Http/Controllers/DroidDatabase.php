<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Club;
use App\Droid;

class DroidDatabase extends Controller
{
    public function index()
    {
        $clubs = Club::all();
        return view('database.index', compact('clubs'));
    }
}
