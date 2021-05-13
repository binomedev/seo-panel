<?php


namespace Binomedev\SeoPanel\Scanners;

use Binomedev\SeoPanel\Contracts\CanBeSeoAnalyzed;
use Binomedev\SeoPanel\Result;
use Binomedev\SeoPanel\Scanner;

class SlugLengthScanner extends Scanner
{
    public function scan(CanBeSeoAnalyzed $model): Result
    {
        $report = Result::make('Slug Length')->message('Slug length should be less than 76 characters');
        $slug = $model->getSeoAttribute('slug');

        // Check slug length to be less than 76 characters
        $passed = strlen($slug) <= 76;

        return $report->status($passed);
    }
}
