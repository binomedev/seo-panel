<?php


namespace Binomedev\SeoPanel\Scanners;


use Binomedev\SeoPanel\CanBeSeoAnalyzed;
use Binomedev\SeoPanel\Report;
use Binomedev\SeoPanel\Scanner;

class FocusKeywordsPresenceScanner extends Scanner
{

    function scan(CanBeSeoAnalyzed $model): Report
    {
        $meta = $model->seoMeta()->first();

        if (empty($meta->keywords)) {
            // Fail
            // Stop testing for keywords presence
            return Report::failed('Focus Keywords Exists')
                ->message('There are no focus keywords set.');
        }

        return $this->scanForPresence($model, $meta);
    }

    private function scanForPresence($model, $meta)
    {
        $keywords = explode(',', $meta->keywords);
        $title = $model->getSeoField('title');
        $slug = $model->getSeoField('slug');
        $seo_title = $meta->title;
        $seo_description = $meta->description;
        $tests = compact('title', 'slug', 'seo_description', 'seo_title');

        // Check if focus keyword is present in slug, title, content
        $report = Report::make('Focus Keywords Presence');
        $meta = [];
        foreach ($keywords as $keyword) {
            $keyword = trim($keyword);

            $fields = [];

            foreach ($tests as $name => $haystack) {
                if (str_contains($haystack, $keyword)) continue;
                $fields[] = $name;
            }

            $meta[$keyword] = $fields;
        }

        if(empty($meta)){
            return $report->status(passed: true)->message('Focus keywords are found everywhere.');
        }

        return $report->message("Focus keywords not found in following fields")->meta($meta);

    }
}
