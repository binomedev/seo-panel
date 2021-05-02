<?php


namespace Binomedev\SeoPanel\Scanners;


use Binomedev\SeoPanel\CanBeSeoAnalyzed;
use Binomedev\SeoPanel\Report;
use Binomedev\SeoPanel\Scanner;

class DescriptionLengthScanner extends Scanner
{

    function scan(CanBeSeoAnalyzed $model): Report
    {
        $report = Report::make('Description Length Scanner', status: false);
        $seo_description = $model->seoMeta->description;

        // Check if it has a seo description
        if (empty($seo_description)) {
            return $report->message('There is not seo description set.');
        }

        // Suggest that seo description should have has less than  160 characters
        if (strlen($seo_description) > 160) {
            // Fail
            return $report->message('There is not seo description set.');
        }

        return $report->status(passed: true);
    }
}
