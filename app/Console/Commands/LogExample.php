<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class LogExample extends Command
{
    protected $signature = 'log:example';

    protected $description = 'Generate an example log entry';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        Log::info('This is an example log entry from Artisan command.');
        $this->info('Log entry has been created.');
    }
}
