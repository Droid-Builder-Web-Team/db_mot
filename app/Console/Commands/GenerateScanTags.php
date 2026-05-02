<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Droid;

class GenerateScanTags extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hunter:generate-tags {--id= : Single Droid ID to generate}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate secure anti-cheat URLs for physical droid tags';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tagSecret = env('TAG_SECRET', 'changeme');
        $baseUrl = config('app.url');

        if ($this->option('id')) {
            $droids = Droid::where('id', $this->option('id'))->get();
        } else {
            $droids = Droid::where('public', 'Yes')->get();
        }

        if ($droids->isEmpty()) {
            $this->error('No public droids found.');
            return;
        }

        $this->info('Secure Tag URLs:');
        $this->table(
            ['ID', 'Name', 'Secure URL'],
            $droids->map(function ($droid) use ($tagSecret, $baseUrl) {
                $hash = substr(hash_hmac('sha256', $droid->id, $tagSecret), 0, 8);
                return [
                    $droid->id,
                    $droid->name,
                    rtrim($baseUrl, '/') . "/scan/{$droid->id}/{$hash}"
                ];
            })->toArray()
        );
    }
}
