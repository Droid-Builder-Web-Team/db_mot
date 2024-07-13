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
        $pastevents = Event::where('date', '<', Carbon::now())
            ->where('date', '>', Carbon::now()->subDays(180))
            ->orderBy('date')->get();
        echo "Count: ".$pastevents->count();
        for ($i = 0; $i < $pastevents->count(); $i++)
        {
                $id = $pastevents[$i]->id;
                $users = $pastevents[$i]->users;
                echo $i. "/".$pastevents->count().": ".$pastevents[$i]->name." ID: ".$id." Attended: ".$users->count();
                echo "\n";
            foreach($users as $user)
                {
                if ($user->event($id)->attended == 0 && $user->event($id)->status == 'yes') {
                        $user->events()->updateExistingPivot($id, ["attended" => 1]);
                }
            }
                echo "\n";
        }
        return 0;
    }
}