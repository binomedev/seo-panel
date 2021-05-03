<?php


namespace Binomedev\SeoPanel\Commands;

use Illuminate\Console\Command;

class PublishCommand extends Command
{
    public $signature = 'seo:publish {--force : Overwrite any existing files}';

    public $description = 'Publish all of the Seo resources';

    public function handle()
    {
        $this->call('vendor:publish', [
            '--tag' => 'seo-config',
            '--force' => $this->option('force'),
        ]);

        $this->call('vendor:publish', [
            '--tag' => 'seo-assets',
            '--force' => true,
        ]);

        $this->call('vendor:publish', [
            '--tag' => 'seo-lang',
            '--force' => $this->option('force'),
        ]);

        $this->call('vendor:publish', [
            '--tag' => 'seo-views',
            '--force' => $this->option('force'),
        ]);

        $this->call('view:clear');
    }
}
