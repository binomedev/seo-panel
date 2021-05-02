<?php


namespace Binomedev\SeoPanel\Scanners;


use Binomedev\SeoPanel\CanBeSeoAnalyzed;
use Binomedev\SeoPanel\Report;
use Binomedev\SeoPanel\Scanner;

class ContentMinLengthScanner extends Scanner
{

    function scan(CanBeSeoAnalyzed $model): Report
    {

        $report = Report::make('Content Min Length');
        $content = $model->getSeoField('content');

        // Check if content is at least 600 characters excluding html and markdown syntax
        // TODO: Strip markdown and html entities
        if (strlen($content < 600)) {
            // Fail
            return $report->message('Content should be at least 600 characters long.');
        }

        return $report->status(passed: true);
    }
}
