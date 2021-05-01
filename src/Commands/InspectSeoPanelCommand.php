<?php

namespace Binomedev\SeoPanel\Commands;

use Binomedev\SeoPanel\Report;
use Binomedev\SeoPanel\SeoPanel;
use Illuminate\Console\Command;

class InspectSeoPanelCommand extends Command
{
    public $signature = 'seo:inspect';

    public $description = 'Inpsects website seo panel.';

    public function handle(SeoPanel $seo)
    {
        $results = $seo->inspect();

        $results->each(function (Report $report) {
            $output = $this->getOutput();
            $output->section($report->name());

            if ($report->hasPassed()) {
                $output->block($report->message(), 'OK', 'fg=green');
            } else {
                $output->block($report->message(), 'WARNING', 'fg=red');
                $output->text("> {$report->help()}");
            }
        });
        $this->newLine();
        $this->comment("Inspection completed. Total {$results->count()} results.");
    }
}
