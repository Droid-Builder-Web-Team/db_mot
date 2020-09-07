<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Droid;
use App\Club;
use Carbon\Carbon;
use App\Notifications\MOTDue;
use App\Notifications\MOTExpired;

class CheckMOT extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'checkmot:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks all existing MOTs';

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
        $today = Carbon::today();
        $expired = Carbon::today()->subYear();
        $expiring = Carbon::today()->subYear()->addMonth();
        foreach(Club::all() as $club)
        {
            if($club->hasOption('mot'))
            {
                $this->info('MOT: Checking droids in club: '.$club->name.' ID: '.$club->id);

                $droids = Droid::where('club_id', $club->id)->get();
                foreach($droids as $droid)
                {
                    $this->info('MOT: Checking droid: '.$droid->name.' MOT Date: '.$droid->motDate().' Expire Date: '
                                  .$expired->format('Y-m-d').' Expiring Date: '.$expiring->format('Y-m-d'));
                    if ($droid->motDate() == $expired->format('Y-m-d'))
                    {
                        $this->info('MOT: Droid MOT expires today: '.$droid->name);
                        foreach($droid->users as $user)
                        {
                            $user->notify(new MOTExpired($droid));
                        }
                    }
                    if ($droid->motDate() == $expiring->format('Y-m-d'))
                    {
                        $this->info('MOT: Droid MOT expires in a month: '.$droid->name);
                        foreach($droid->users as $user)
                        {
                            $user->notify(new MOTDue($droid));
                        }
                    }
                }
            }
        }
        return 0;
    }
}
