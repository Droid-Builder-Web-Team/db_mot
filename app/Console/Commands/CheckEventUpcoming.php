<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Event;
use Carbon\Carbon;
use App\Notifications\EventUpcoming;
use App\Notifications\EventUpcomingEo;

class CheckEventUpcoming extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:eventupcoming';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for upcoming events and notify users';

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
        $upcoming = Carbon::today()->addWeek();
        $events = Event::whereDate('date', '>=', Carbon::now())->get();
        $this->info('Event: One weeks time: '.$upcoming);
        foreach($events as $event)
        {
            $this->info('Event: Checking event: '.$event->name.' Date: '.$event->date);
            if ($event->date == $upcoming->format('Y-m-d')) {
                $this->info('Event: An event is happening in a week: '.$event->name);
                foreach($event->users as $user)
                {
                    $this->info('Event: Notifying: '.$user->forename);
                    $user->notify(new EventUpcoming($event));
                }
                # Also notify organiser
                $event->organiser->notify(new EventUpcomingEo($event));
            }
        }
        return 0;
    }
}
