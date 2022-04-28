<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Stat;

class StatsController extends Controller
{

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:Edit Events');
    }

    public function getStat($stat)
    {
        $stats = Stat::where("name", $stat)->get(['created_at AS x', 'value AS y']);
        return response()->json($stats);
    }

    public function index()
    {
        return view('admin.stats.index');
    }
}
