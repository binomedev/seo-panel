<?php


namespace Binomedev\SeoPanel\Scanners;


use Binomedev\SeoPanel\CanBeSeoAnalyzed;
use Binomedev\SeoPanel\Report;
use Binomedev\SeoPanel\Scanner;

class SchemaExistsScanner extends Scanner
{

    function scan(CanBeSeoAnalyzed $model): Report
    {
        $report = Report::make('Schema');
        $schema = $model->seoMeta->schema;

        if (empty($schema)) {
            // Fail
            $reports[] = $report->message('There is no schema type set.');
        }

        return $report->status(passed: true)->message('Scheme is set to: ' . $schema);
    }
}
