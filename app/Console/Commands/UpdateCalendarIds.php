<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;

class UpdateCalendarIds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:calendar_id';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate calendar IDs for those users without';

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
        $users = User::all();
        foreach ($users as $user) {
            if ($user->calendar_id == "none") {
                $user->calendar_id = $user->generateID(60);
                $user->save();
            }
        }
        return Command::SUCCESS;
    }
}
