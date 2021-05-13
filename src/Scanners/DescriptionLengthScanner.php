<?php


namespace Binomedev\SeoPanel\Scanners;

use Binomedev\SeoPanel\Contracts\CanBeSeoAnalyzed;
use Binomedev\SeoPanel\Result;
use Binomedev\SeoPanel\Scanner;

class DescriptionLengthScanner extends Scanner
{
    public function scan(CanBeSeoAnalyzed $model): Result
    {
        $report = Result::make('Description Length', status: false)
            ->message('Seo description should have has less than 160 characters.');


        $seo_description = $model->seoMeta->description;

        // Check if it has a seo description
        if (empty($seo_description)) {
            return $report->message('There is not seo description set.');
        }

        $passed = strlen($seo_description) <= 160;

        return $report->status($passed);
    }
}
