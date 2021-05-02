<?php

namespace Binomedev\SeoPanel;

use Illuminate\Support\Collection;

class Seo
{
    private array $scanners = [];
    private array $inspectors = [];

    public function useInspector(string|array $inspectors): static
    {
        return $this->use($inspectors, $this->inspectors);
    }

    private function use(string|array $items, &$iterable): static
    {
        if (is_array($items)) {
            $iterable = array_merge($iterable, $items);

            return $this;
        }

        $iterable[] = $items;

        return $this;
    }

    public function useScanner(string|array $scanners): static
    {
        return $this->use($scanners, $this->scanners);
    }

    /**
     * Inspects the website for generic SEO configuration
     *
     * @return Collection
     */
    public function inspect(): Collection
    {
        return collect($this->inspectors)->map(function ($inspector) {
            return app($inspector)->inspect();
        });
    }

    public function analyze(CanBeSeoAnalyzed|array $model)
    {
        if (!$model->relationLoaded('seoMeta')) {
            $model->load('seoMeta');
        }

        // Run tests
        return collect($this->scanners)->map(fn($scanner) => app($scanner)->scan($model));
    }
}
