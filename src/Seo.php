<?php

namespace Binomedev\SeoPanel;

use Artesaos\SEOTools\Facades\SEOTools;
use Binomedev\SeoPanel\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Http\Response as IlluminateResponse;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;

class Seo
{
    private array $scanners = [];
    private array $inspectors = [];
    private $options = null;

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

    public function analyze(CanBeSeoAnalyzed|array $model)
    {
        if (!$model->relationLoaded('seoMeta')) {
            $model->load('seoMeta');
        }

        // Run tests
        return collect($this->scanners)->map(fn($scanner) => app($scanner)->scan($model));
    }

    public function modifyResponse(Request $request, Response $response)
    {
        /**
         * Black magic, night walker
         * She haunts me like no other
         * Nobody told me code is pain
         */

        $content = $response->getContent();
        $head = SEOTools::generate(true);

        // Position the meta tags right at the beginning of the head tag.
        $pos = strripos($content, '<head>');
        if (false !== $pos) {
            $content = substr($content, 6, $pos) . $head . substr($content, $pos);
        }

        $original = null;
        if ($response instanceof IlluminateResponse && $response->getOriginalContent()) {
            $original = $response->getOriginalContent();
        }

        $response->setContent($content);

        // Restore original response (eg. the View or Ajax data)
        if ($original) {
            $response->original = $original;
        }
    }
}
