<?php


namespace Binomedev\SeoPanel\Inspectors;


use Binomedev\SeoPanel\Inspector;
use Binomedev\SeoPanel\Report;
use Illuminate\Support\Facades\Http;

class SitemapInspector extends Inspector
{

    function inspect(): Report
    {
        $report = new Report('Sitemap Inspector');

        if ($this->checkFileNotExists()) {
            return $report->status($passed = false)
                ->message(__('File does not exists.'))
                ->help(__('You can generate a new sitemap by running the following artisan command: php artisan seo:generate-sitemap'));
        }

        if ($this->checkIfCannotBeAccessed()) {
            return $report->status($passed = false)
                ->message(__('File exists, but it cannot be accessed. '))
                ->help('Please, make sure that all the permissions are set correctly.');
        }


        return $report->status($passed = true)->message(__('Sitemap exists.'));
    }

    private function checkFileNotExists()
    {
        return !file_exists(public_path('sitemap.xml'));
    }

    private function checkIfCannotBeAccessed()
    {
        return !Http::get(url('/sitemap.xml'))->ok();
    }


}
