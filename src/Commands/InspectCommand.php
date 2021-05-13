<?php

namespace Binomedev\SeoPanel\Commands;

use Binomedev\SeoPanel\Result;
use Binomedev\SeoPanel\Seo;
use Illuminate\Console\Command;

class InspectCommand extends Command
{
    public $signature = 'seo:inspect';

    public $description = 'Runs all inspectors against your website.';

    public function handle(Seo $seo)
    {
        $results = $seo->inspect();

        $results->each(function (Result $result) {
            $output = $this->getOutput();
            $output->section($result->name());

            if ($result->isPassed()) {
                $output->block($result->message(), 'OK', 'fg=green');
            } else {
                $output->block($result->message(), 'WARNING', 'fg=red');
                $output->text("> {$result->help()}");
            }
        });

        $this->newLine();
        $this->comment("Inspection completed. Total {$results->count()} results.");
    }
}
