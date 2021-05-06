<?php

namespace Binomedev\SeoPanel\Commands;

use Binomedev\SeoPanel\Report;
use Binomedev\SeoPanel\Seo;
use Illuminate\Console\Command;

class InspectCommand extends Command
{
    public $signature = 'seo:inspect';

    public $description = 'Runs all inspectors against your website.';

    public function handle(Seo $seo)
    {
        $results = $seo->inspect();

        $results->each(function (Report $report) {
            $output = $this->getOutput();
            $output->section($report->name());

            if ($report->isPassed()) {
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
