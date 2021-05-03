<?php


namespace Binomedev\SeoPanel;

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
