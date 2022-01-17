<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Event;
use Carbon\Carbon;
use App\Notifications\EventMOT;

class CheckEventMOT extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:eventmot';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for upcoming events and notify users if they have an MOT booked';

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
        $upcoming = Carbon::today()->addDays(2);
        $events = Event::whereDate('date', '>=', Carbon::now())->get();
        $this->info('Event: Couple of days time: '.$upcoming);
        foreach($events as $event)
        {
            $this->info('Event: Checking event: '.$event->name.' Date: '.$event->date);
            if ($event->date == $upcoming->format('Y-m-d')) {
                $this->info('Event: An event is happening in a couple of days: '.$event->name);
                foreach($event->users as $user)
                {
                    if($user->pivot->mot_required) {
                        $this->info('Event: Notifying: '.$user->forename);
                        $user->notify(new EventMOT($event));
                    }
                }
            }
        }
        return 0;
    }
}
