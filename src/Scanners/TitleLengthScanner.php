<?php


namespace Binomedev\SeoPanel\Scanners;


use Binomedev\SeoPanel\CanBeSeoAnalyzed;
use Binomedev\SeoPanel\Report;
use Binomedev\SeoPanel\Scanner;

class TitleLengthScanner extends Scanner
{

    function scan(CanBeSeoAnalyzed $model): Report
    {
        $report = Report::make('Title Length', status: false);
        $seo_title = $model->seoMeta->title;


        // Check if it has a seo title
        if (empty($seo_title)) {
            // Fail
            return $report->message('Seo title is not set.');
        }

        // Suggest that seo title should have less than 60 characters
        if (strlen($seo_title) > 60) {
            // Fail
            return $report->message('The seo title should have less than 60 characters.');
        }

        return $report->status(passed: true)->message('The seo title is less than 60 characters.');
    }
}
