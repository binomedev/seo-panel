<?php


namespace Binomedev\SeoPanel\Scanners;

use Binomedev\SeoPanel\CanBeSeoAnalyzed;
use Binomedev\SeoPanel\Report;
use Binomedev\SeoPanel\Scanner;
use Illuminate\Pipeline\Pipeline;

class ContentMinLengthScanner extends Scanner
{
    private $contentCleaners = [];

    public function scan(CanBeSeoAnalyzed $model): Report
    {
        $report = Report::make('Content Min Length')
            ->message('Content should be at least 600 characters long.');

        $content = $this->cleanContent($model->getSeoAttribute('content'));

        // Check if content is at least 600 characters excluding html and any syntax that shouldn't count
        $count = strlen($content);
        $report->add('count', $count);

        $passed = $count > 600;

        return $report->status($passed);
    }

    private function cleanContent($content)
    {
        $pipeline = app(Pipeline::class);

        return $pipeline->send($content)
            ->through([
                // Strip all html tags, to measure only the real content
                function ($content, \Closure $next) {
                    $content = strip_tags(htmlspecialchars_decode($content));

                    return $next($content);
                },

                ...$this->contentCleaners,
            ])
            ->thenReturn();
    }
}
