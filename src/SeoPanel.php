<?php

namespace Binomedev\SeoPanel;

use Illuminate\Support\Collection;

class SeoPanel
{
    private array $inspectors = [];

    public function useInspector(string|array $inspectors): SeoPanel
    {
        if (is_array($inspectors)) {
            $this->inspectors = array_merge($this->inspectors, $inspectors);

            return $this;
        }

        $this->inspectors[] = $inspectors;

        return $this;
    }

    public function inspect(): Collection
    {
        return collect($this->inspectors)->map(function ($inspector) {
            return app($inspector)->inspect();
        });
    }
}
