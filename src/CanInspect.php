<?php


namespace Binomedev\SeoPanel;

interface CanInspect
{
    public function inspect() : Report;

    public function name(): string;

    public function help(): string;
}
