<?php


namespace Binomedev\SeoPanel\ValueObjects;


use Binomedev\SeoPanel\Models\Report;
use Illuminate\Support\Collection;

class Score
{
    private int $value;
    private int $maxScore;

    // Example
    private $scores = [
        'h1_heading' => 5,
        'h2_headings' => 2,
        'img_alt' => 4,
        'keywords_meta' => 5,
        'links_ratio' => 3,
        'title_length' => 4,
        'permalink_structure' => 7,
        'focus_keywords' => 3,
        'post_titles' => 4,

        // Advanced SEO.
        'canonical' => 5,
        'noindex' => 7,
        'non_www' => 4,
        'opengraph' => 2,
        'robots_txt' => 3,
        'schema' => 3,
        'sitemaps' => 3,
        'search_console' => 1,

        // Performance.
        'image_header' => 3,
        'minify_css' => 2,
        'minify_js' => 1,
        'page_objects' => 2,
        'page_size' => 3,
        'response_time' => 3,

        // Security.
        'directory_listing' => 1,
        'safe_browsing' => 8,
        'ssl' => 7,
    ];

    public function __construct(int $value = 0, $maxScore = 100)
    {
        $this->maxScore = $maxScore;
        $this->value = $value;
    }

    public static function make(...$args):static
    {
        return new static(...$args);
    }
    public function calculate(Collection $results): static
    {
        $total = $results->count();
        $totalPassed = $results->filter(fn($result) => $result->isPassed())->count();
        // How many passed of total: 10 tests = 100 score
        $this->value = ($totalPassed / $total) * $this->maxScore;

        return $this;
    }

    public function value(): int
    {
        return $this->value;
    }

    public function severity(): string
    {
        $score = $this->value;

        // > 75 <= 100
        if ($score > 75 && $score <= 100) {
            return Report::SEVERITY_LOW;
        }

        //> 55 <= 75
        if ($score > 55 && $score <= 75) {
            return Report::SEVERITY_MEDIUM;
        }

        //  > 30 <= 55
        if ($score > 30 && $score <= 55) {
            return Report::SEVERITY_HIGH;
        }

        // <= 30
        return Report::SEVERITY_CRITICAL;
    }
}
