<?php


namespace Binomedev\SeoPanel\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    public $signature = 'seo:install';

    public $description = 'Installs all the needed data.';

    public function handle()
    {
        // Publish migrations
        $this->call('vendor:publish', [
            '--tag' => 'seo-migrations',
            '--force' => $this->option('force'),
        ]);

        // Migrate
        $this->call('migrate');

        // Add default options data

        // Run health checks

        // Run Inspector
    }
}
