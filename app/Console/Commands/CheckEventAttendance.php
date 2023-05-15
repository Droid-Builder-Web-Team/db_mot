<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Event;
use Carbon\Carbon;

class CheckEventAttendance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:eventattendance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for past events and set attendance';

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
        $events = Event::whereDate('date', '<=', Carbon::now())->get();
        foreach($events as $event)
        {
            foreach( $event->users as $user)
            {
                if($user->event($event->id)->attended == 0)
                {
                    $this->info('Event: Marking '.$user->forename.' '.$user->surname.' as in attendance for event id '.$event->id);
                    $user->events()->updateExistingPivot($event->id, ["attended" => 1]);
                }
            }
        }
        return 0;
    }
}
