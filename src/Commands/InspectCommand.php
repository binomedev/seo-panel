<?php

namespace Binomedev\SeoPanel\Commands;


use CodrinAxinte\SorceryCore\Result;
use CodrinAxinte\SorceryCore\Services\SorceryCore;
use Illuminate\Console\Command;

class InspectCommand extends Command
{
    public $signature = 'seo:inspect';

    public $description = 'Runs all inspectors against your website.';

    public function handle(SorceryCore $sorceryCore)
    {
        $results = $sorceryCore->inspect();

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
