<?php


namespace Binomedev\SeoPanel;


interface CanInspect
{
    function inspect() : Report;

    function name(): string;

    function help(): string;
}
