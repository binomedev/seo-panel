<?php


namespace Binomedev\SeoPanel\Inspectors;

use Binomedev\SeoPanel\Report;

interface Inspects
{
    public function inspect() : Report;

    public function name(): string;

    public function help(): string;
}
