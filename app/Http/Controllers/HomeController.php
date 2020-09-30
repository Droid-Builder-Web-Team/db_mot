<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
    $this->middleware('verified');
  }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::check()) {
          return redirect('user/'.auth()->user()->id);
        } else {
          return view('home');
        }
    }
}
