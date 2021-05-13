<?php

namespace Binomedev\SeoPanel;


use Artesaos\SEOTools\SEOTools;
use Binomedev\SeoPanel\Contracts\CanBeSeoAnalyzed;
use Binomedev\SeoPanel\Contracts\CanInspect;
use Binomedev\SeoPanel\Contracts\CanScan;
use Binomedev\SeoPanel\Models\Option;
use Binomedev\SeoPanel\Models\Report;
use Binomedev\SeoPanel\Traits\HasSeo;
use Illuminate\Support\Collection;

class Seo
{
    private array $scanners;
    private $scannersCache;
    private array $inspectors;
    private $options = null;
    private SEOTools $tools;

    /**
     * Seo constructor.
     * @param SEOTools $tools
     */
    public function __construct(SEOTools $tools)
    {
        $this->tools = $tools;

        $this->scanners = config('seo.scanners', []);
        $this->inspectors = config('seo.inspectors', []);
    }

    public function registerInspector(string|array $inspectors): static
    {
        return $this->registerService($inspectors, $this->inspectors);
    }

    private function registerService(string|array $items, &$iterable): static
    {
        if (is_array($items)) {
            $iterable = array_merge($iterable, $items);

            return $this;
        }

        $iterable[] = $items;

        return $this;
    }

    public function registerScanner(string|array $scanners): static
    {
        return $this->registerService($scanners, $this->scanners);
    }

    public function tools(): SEOTools
    {
        return $this->tools;
    }

    public function setDefaultTags(): static
    {
        // TODO: This operation should be cached
        $options = $this->options();

        $this->tools->metatags()->setTitleDefault($options->get('title', config('app.name')));
        $this->tools->metatags()->setTitleSeparator(' ' . $options->get('title_separator', '-') . ' ');
        $this->tools->setDescription($options->get('description'));

        return $this;
    }

    public function options($name = null, $default = null)
    {
        if (is_null($this->options)) {
            // Cache options
            $this->options = Option::query()->pluck('value', 'name');
        }

        if (is_null($name)) {
            return $this->options;
        }

        return $this->options->get($name, $default);
    }

    public function entangle(CanBeSeoAnalyzed $entity): static
    {
        if ($entity->relationLoaded('seoMeta')) {
            $entity->load('seoMeta');
        }

        $meta = $entity->seoMeta;

        $this->tools->setTitle($meta->title);
        $this->tools->setDescription($meta->description);
        $this->tools->metatags()->setKeywords($meta->keywords);

        // TODO: Should add more tags generated such as Schema, jsonLd, Images, etc

        return $this;
    }

    /**
     * Inspects the website for generic SEO configuration
     *
     * @param string|CanInspect|null $inspector
     * @return Collection|Result
     */
    public function inspect(string|CanInspect $inspector = null): Collection|Result
    {
        if (!is_null($inspector)) {
            if ($inspector instanceof CanInspect) {
                return $inspector->inspect();
            }

            return app($inspector)->inspect();
        }

        return collect($this->inspectors)->map(fn($inspector) => app($inspector)->inspect());
    }

    public function analyze(CanBeSeoAnalyzed|array $model, string|CanScan $scanner = null): Collection|Result
    {
        if (!$model->relationLoaded('seoMeta')) {
            $model->load('seoMeta');
        }

        if (!is_null($scanner)) {
            if ($scanner instanceof CanScan) {
                return $scanner->scan($model);
            }

            return app($scanner)->scan($model);
        }

        // Run tests
        return $this->scanners()->map(fn($scanner) => app($scanner)->scan($model));
    }

    private function scanners(): Collection
    {
        if (!$this->scannersCache) {
            $this->scannersCache = collect($this->scanners);
        }

        return $this->scannersCache;
    }

    public function findReport($seoableId, $seoableType)
    {
        return Report::where('type', Report::TYPE_ANALYSIS)
            ->where('seoable_id', $seoableId)
            ->where('seoable_type', $seoableType)
            ->latest()
            ->first();
    }

    public function issueReport($seoable, Collection $results, $type): Report
    {
        $score = $this->calculateScore($results);

        return $seoable->seoReports()->create([
            'score' => $score,
            'severity' => $this->calculateSeverity($score),
            'type' => $type,
            'results' => $results->toArray(),
        ]);
    }

    public function calculateScore(Collection $results)
    {
        $maxScore = 100;

        $total = $results->count();
        $totalPassed = $results->filter(fn($result) => $result->isPassed())->count();
        // How many passed of total: 10 tests = 100 score
        return ($totalPassed / $total) * $maxScore;
    }

    public function calculateSeverity(int $score): string
    {

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
