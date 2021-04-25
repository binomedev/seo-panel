<?php

namespace Binomedev\SeoPanel\Commands;

use Illuminate\Console\Command;

class InstallSeoPanelCommand extends Command
{
    public $signature = 'seo-panel:install';

    public $description = 'Install seo panel.';

    public function handle()
    {
        $this->comment('All done');
    }
}
