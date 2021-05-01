<?php


namespace Binomedev\SeoPanel\Inspectors;


abstract class Inspector implements Inspects
{


    function name(): string
    {
        return '';
    }

    function help(): string
    {
        return '';
    }
}
