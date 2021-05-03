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

    public function modifyResponse(Request $request, Response $response)
    {
        /**
         * Black magic, night walker
         * She haunts me like no other
         * Nobody told me code is pain
         */

        $content = $response->getContent();
        $this->boot();
        $head = SEOTools::generate(true);

        // Position the meta tags right at the beginning of the head tag.
        $tag = '<head>';
        $pos = strripos($content, $tag) + strlen($tag);
        if (false !== $pos) {
            $start = substr($content, 0, $pos);
            $end = substr($content, $pos);
            $content = $start . $head . $end;
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

    public function boot()
    {
        // TODO: This should be cached
        $options = $this->options();

        // TODO: fix issue when overriding
        SEOTools::metatags()->setTitleDefault($options->get('title', config('app.name')));
        SEOTools::metatags()->setTitleSeparator($options->get('title_separator', '-'));
        SEOTools::setDescription($options->get('description'));

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
}
