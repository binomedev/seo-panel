<?php


namespace Binomedev\SeoPanel\Scanners;

use Binomedev\SeoPanel\Contracts\CanBeSeoAnalyzed;
use Binomedev\SeoPanel\Result;
use Binomedev\SeoPanel\Scanner;

class FocusKeywordsPresenceScanner extends Scanner
{
    public function scan(CanBeSeoAnalyzed $model): Result
    {
        $meta = $model->seoMeta()->first();

        if (empty($meta->keywords)) {
            // Fail
            // Stop testing for keywords presence
            return Result::failed('Focus Keywords Exists')
                ->message('There are no focus keywords set.');
        }

        return $this->scanForPresence($model, $meta);
    }

    private function scanForPresence(CanBeSeoAnalyzed $model, $meta)
    {

        // TODO: Scan using database search.
        $tests = [
            'title' => $model->getSeoAttribute('title'),
            'slug' => $model->getSeoAttribute('slug'),
            'content' => $model->getSeoAttribute('content'),
            'seo_title' => $meta->title,
            'seo_description' => $meta->description,
        ];

        // Check if focus keyword is present in slug, title, content
        $report = Result::make('Focus Keywords Presence');
        $keywords = $meta->keywordsList;
        $group = [];
        foreach ($keywords as $keyword) {
            $keyword = trim($keyword);

            $fields = [];

            foreach ($tests as $name => $haystack) {
                if (str_contains($haystack, $keyword)) {
                    continue;
                }
                $fields[] = $name;
            }

            if (! empty($fields)) {
                $group[$keyword] = $fields;
            }
        }

        if (empty($group)) {
            return $report->status(passed: true)->message('Focus keywords are found everywhere.');
        }



        $missingKeywords = collect($group)->flatten()->implode(', ');
        return $report->message("Focus keywords not found in following fields: {$missingKeywords}")->meta($group);
    }
}
