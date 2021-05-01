<?php


namespace Binomedev\SeoPanel\Inspectors;

abstract class Inspector implements Inspects
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
