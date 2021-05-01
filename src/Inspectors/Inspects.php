<?php


namespace Binomedev\SeoPanel\Inspectors;


use Binomedev\SeoPanel\Report;

interface Inspects
{
    function inspect() : Report;

    function name(): string;

    function help(): string;
}
