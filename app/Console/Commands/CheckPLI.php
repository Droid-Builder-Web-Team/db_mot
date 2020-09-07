<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\User;
use App\Notifications\PLIDue;

class CheckPLI extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'checkpli:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check all existing PLI';

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
        $expired = Carbon::today()->subYear();
        $expiring = Carbon::today()->subYear()->addMonth();
        $users = User::all();
        foreach($users as $user)
        {
            $this->info('PLI: Checking droid: '.$user->forename.' PLI Date: '.$user->pli_date);
            if ($user->pli_date == $expired->format('Y-m-d'))
            {
                $this->info('PLI: User PLI expires today: '.$user->forename);
                $user->notify(new PLIDue);
            }
            if ($user->pli_date == $expiring->format('Y-m-d'))
            {
                $this->info('PLI: User PLI expires in a month: '.$user->forename);
                $user->notify(new PLIDue);
            }
        }
        return 0;
    }
}
