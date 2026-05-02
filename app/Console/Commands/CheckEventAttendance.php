<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Event;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
        $pastevents = Event::where('date', '<', Carbon::now())
            ->where('date', '>', Carbon::now()->subDays(60))
            ->orderBy('date');

        $totalCount = $pastevents->count();
        $this->line("Count: " . $totalCount);

        $processedCount = 0;
        $pastevents->with('users')->chunk(10, function ($events) use (&$processedCount, $totalCount) {
            foreach ($events as $event) {
                $processedCount++;
                $id = $event->id;
                $users = $event->users;

                $this->line($processedCount . "/" . $totalCount . ": " . $event->name . " ID: " . $id . " Attended: " . $users->count());

                DB::table('members_events')
                    ->where('event_id', $id)
                    ->where('status', 'yes')
                    ->where('attended', 0)
                    ->update(['attended' => 1]);
            }
        });

        return 0;
    }
}
