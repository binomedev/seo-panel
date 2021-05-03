<?php


namespace Binomedev\SeoPanel\Scanners;

use Binomedev\SeoPanel\CanBeSeoAnalyzed;
use Binomedev\SeoPanel\Report;
use Binomedev\SeoPanel\Scanner;

class TitleLengthScanner extends Scanner
{
    public function scan(CanBeSeoAnalyzed $model): Report
    {
        $report = Report::make('Title Length')->message('The seo title should have less than 60 characters.');
        $seo_title = $model->seoMeta->title;

        // Check if it has a seo title
        if (empty($seo_title)) {
            // Fail
            return $report->message('Seo title is not set.');
        }

        // Suggest that seo title should have less than 60 characters
        $passed = strlen($seo_title) <= 60;

        return $report->status($passed);
    }
}
