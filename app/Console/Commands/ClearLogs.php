<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use File;

class ClearLogs extends Command
{
    protected $signature = 'logs:clear';

    protected $description = 'Clear the application logs';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $logFiles = File::glob(storage_path('logs/*.log'));

        foreach ($logFiles as $logFile) {
            File::delete($logFile);
        }

        $this->info('Logs have been cleared!');
    }
}
