<?php


namespace Binomedev\SeoPanel\Scanners;

use Binomedev\SeoPanel\Contracts\CanBeSeoAnalyzed;
use Binomedev\SeoPanel\Result;
use Binomedev\SeoPanel\Scanner;

class SchemaExistsScanner extends Scanner
{
    public function scan(CanBeSeoAnalyzed $model): Result
    {
        $report = Result::make('Schema');
        $schema = $model->seoMeta->schema;

        if (empty($schema)) {
            // Fail
            return $report->message('There is no schema type set.');
        }

        return $report->status(passed: true)->message('Scheme is set to: ' . $schema);
    }
}
