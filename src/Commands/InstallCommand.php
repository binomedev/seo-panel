<?php


namespace Binomedev\SeoPanel\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    public $signature = 'seo:install';

    public $description = 'Installs all the needed data.';

    public function handle()
    {
        // Migrate
        // Add default options data
        // Run health checks
        // Run Inspector
    }
}
