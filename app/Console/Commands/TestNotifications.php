<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\Droid;
use App\Notifications\AchievementAdded;
use App\Notifications\EventCancelled;
use App\Notifications\EventChanged;
use App\Notifications\EventCreated;
use App\Notifications\EventUpcoming;
use App\Notifications\EventUpdated;
use App\Notifications\MOTAdded;
use App\Notifications\MOTDue;
use App\Notifications\MOTExpired;
use App\Notifications\NewUser;
use App\Notifications\PLIDue;
use App\Notifications\PLIExpired;

class TestNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:test {user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a bunch of notifications';

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
        $userID = $this->argument('user');
        $user = User::find($userID);
        $droid = $user->droids()->first();
        $user->notify(new PLIDue($user));
        $user->notify(new MOTDue($droid));
        $user->notify(new NewUser($user));
        return 0;
    }
}
