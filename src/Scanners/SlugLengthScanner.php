<?php


namespace Binomedev\SeoPanel\Scanners;


use Binomedev\SeoPanel\CanBeSeoAnalyzed;
use Binomedev\SeoPanel\Report;
use Binomedev\SeoPanel\Scanner;

class SlugLengthScanner extends Scanner
{

    function scan(CanBeSeoAnalyzed $model): Report
    {
        $report = Report::make('Slug Length')->message('Slug length should be less than 76 characters');
        $slug = $model->getSeoField('slug');

        // Check slug length to be less than 76 characters
        $passed = strlen($slug) <= 76;

        return $report->status($passed);
    }
}
