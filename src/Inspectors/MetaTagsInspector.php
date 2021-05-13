<?php


namespace Binomedev\SeoPanel\Inspectors;

use Binomedev\SeoPanel\Inspector;
use Binomedev\SeoPanel\Result;
use Binomedev\SeoPanel\SeoFacade;

class MetaTagsInspector extends Inspector
{
    public function inspect(): Result
    {
        // Check for default title
        // Check for default description (tagline)

        $options = SeoFacade::options();
        $report = Result::make('Default Meta');

        if ($options->hasNot('title') && $options->hasNot('description')) {
            return $report->message('No meta are set.');
        }

        if ($options->hasNot('title')) {
            return '';
        }

        if ($options->hasNot('description')) {
            return '';
        }

        return $report;
    }
}
