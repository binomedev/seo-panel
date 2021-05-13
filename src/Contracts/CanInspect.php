<?php


namespace Binomedev\SeoPanel\Contracts;

use Binomedev\SeoPanel\Result;

interface CanInspect
{
    public function inspect() : Result;

    public function name(): string;

    public function help(): string;
}
