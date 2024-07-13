<?php


/**
 * Dashboard Controller
 * php version 7.4
 *
 * @category Controller
 * @package  Controllers
 * @author   Darren Poulson <darren.poulson@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use App\Droid;
use App\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Toastr;

/**
 * DashboardController
 *
 * @category Class
 * @package  Controllers
 * @author   Darren Poulson <darren.poulson@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */
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
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $users = User::all();
        $droids = Droid::all();
        $badges = DB::table('id_list')->get();
        $events = Event::whereDate('date', '>=', Carbon::now())
            ->orderBy('date', 'asc')
            ->get();
        $active = User::whereDate('last_activity', '>', Carbon::today()->subDays(60))
            ->count();

        $paypli = [];
        foreach ($users as $user) 
        {
            if (!$user->validPLI()) {
                foreach ($user->droids as $droid) 
                {
                    if ($droid->hasMOT()) {
                        array_push($paypli, $user);
                        break;
                    }
                }
            }
        }
        return view(
            'admin.dashboard', compact(
                'users', 'droids', 'events', 'badges', 'active', 'paypli'
            )
        );
    }


}
