<?php


namespace Binomedev\SeoPanel\Scanners;

use Binomedev\SeoPanel\Contracts\CanBeSeoAnalyzed;
use Binomedev\SeoPanel\Result;
use Binomedev\SeoPanel\Scanner;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Str;

class ContentMinLengthScanner extends Scanner
{
    private $contentCleaners = [];

    public function scan(CanBeSeoAnalyzed $model): Result
    {
        $report = Result::make('Content Min Length')
            ->message('Content should be at least 600 words long.');

        $content = $this->cleanContent($model->getSeoAttribute('content'));

        // Check if content is at least 600 words long, excluding html and any syntax that shouldn't count
        $count = Str::wordCount($content);
        $report->add('count', $count);

        $passed = $count > 600;

        return $report->status($passed);
    }

    private function cleanContent($content)
    {
        return app(Pipeline::class)
            ->send($content)
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
