<?php


namespace Binomedev\SeoPanel;

use Binomedev\SeoPanel\Contracts\CanInspect;

abstract class Inspector implements CanInspect
{
    public function name(): string
    {
        return '';
    }

    public function help(): string
    {
        return '';
    }
}
