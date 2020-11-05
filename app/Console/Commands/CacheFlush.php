<?php

namespace App\Console\Commands;

use App\Jobs\ProcessNotificationJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class CacheFlush extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:flush';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear cache for view, route, config';

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
     * @return void
     */
    public function handle()
    {
        Artisan::call('view:clear');
        Artisan::call('route:clear');
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        Artisan::call('clear-compiled');

        $this->info('Application cache cleared.');
    }
}
