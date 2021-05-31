<?php

namespace Binomedev\SeoPanel;


use Artesaos\SEOTools\SEOTools;
use Binomedev\SeoPanel\Models\Option;
use Binomedev\SeoPanel\Models\Report;
use CodrinAxinte\SorceryCore\Contracts\CanBeSeoAnalyzed;
use CodrinAxinte\SorceryCore\ValueObjects\Score;
use Illuminate\Support\Collection;

class Seo
{

    private $options = null;
    private SEOTools $tools;


    /**
     * Seo constructor.
     * @param SEOTools $tools
     */
    public function __construct(SEOTools $tools)
    {
        $this->tools = $tools;

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
        if ($entity->relationLoaded('seo')) {
            $entity->load('seo');
        }

        $seo = $entity->seo;

        $this->tools->setTitle($seo->title);
        $this->tools->setDescription($seo->description);
        $this->tools->metatags()->setKeywords($seo->keywords);

        // TODO: Should add more tags generated such as Schema, jsonLd, Images, etc

        return $this;
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
        $score = Score::make()->calculate($results);

        return $seoable->seoReports()->create([
            'score' => $score->value(),
            'severity' => $score->severity(),
            'type' => $type,
            'results' => $results->toArray(),
        ]);
    }
}
