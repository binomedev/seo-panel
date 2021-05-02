<?php


namespace Binomedev\SeoPanel\Scanners;


use Binomedev\SeoPanel\CanBeSeoAnalyzed;
use Binomedev\SeoPanel\Report;
use Binomedev\SeoPanel\Scanner;

class SlugLengthScanner extends Scanner
{

    function scan(CanBeSeoAnalyzed $model): Report
    {
        $report = Report::make('Slug Length');
        $slug = $model->getSeoField('slug');

        // Check slug length to be less than 76 characters
        if (strlen($slug) > 76) {
            // Fail
            return $report->message('Slug length should be less than 76 characters');
        }

        return $report->status(passed: true);
    }
}
