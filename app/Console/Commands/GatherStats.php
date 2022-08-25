<?php

/**
 * Command to gather stats
 * php version 7.4
 *
 * @category Command
 * @package  Commands
 * @author   Darren Poulson <darren.poulson@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Stat;
use App\Event;
use App\PartsRunData;
use App\User;
use App\Droid;
use App\Comment;
use App\Location;
use App\MOT;
use App\Achievement;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Gather Stats
 *
 * @category Class
 * @package  Commands
 * @author   Darren Poulson <darren.poulson@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */
class GatherStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stats:gather';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gather stats about the system and store in database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $stats['total_users'] = User::count();
        $stats['total_droids'] = Droid::count();
        $stats['total_events'] = Event::count();
        $stats['total_partruns'] = PartsRunData::count();
        $stats['total_comments'] = Comment::count();
        $stats['total_locations'] = Location::count();
        $stats['total_mots'] = MOT::count();
        $stats['achievements_awarded'] = DB::table('members_achievements')->count();
        $stats['users_active_day'] = User::whereDate(
            'last_activity', '>', Carbon::now()->subDays(1)
        )->count();
        $stats['users_active_week'] = User::whereDate(
            'last_activity', '>', Carbon::now()->subDays(7)
        )->count();
        $stats['users_active_month'] = User::whereDate(
            'last_activity', '>', Carbon::now()->subMonths(1)
        )->count();
        $stats['users_cleared'] = User::whereDate(
            'pli_date', '>', Carbon::today()->subYears(1)
        )->count();
        $stats['events_upcoming'] = Event::whereDate(
            'date', '>=', Carbon::now()
        )->count();
        $stats['partsrun_active'] = PartsRunData::where('status', 'Active')->count();
        $stats['partsrun_gathering'] = PartsRunData::where(
            'status', 'Gathering_Interest'
        )->count();
        $stats['partsrun_inactive'] = PartsRunData::where(
            'status', 'Inactive'
        )->count();

        $count = 0;
        foreach (Droid::all() as $droid) {
            if ($droid->hasFullMOT()) {
                $count++;
            }
        }
        $stats['droids_full_mot'] = $count;

        $count = 0;
        foreach (Droid::all() as $droid) {
            if ($droid->hasAdvisoryMOT()) {
                $count++;
            }
        }
        $stats['droids_advisory_mot'] = $count;

        $count = 0;
        foreach (Droid::all() as $droid) {
            if ($droid->hasWIPMOT()) {
                $count++;
            }
        }
        $stats['droids_wip_mot'] = $count;

        foreach ($stats as $stat => $value) {
            Stat::create(
                [
                    'name' => $stat,
                    'value' => $value
                ]
            );
            echo $stat . " => " . $value . "\n";
        }

    }
}
