<?php


namespace Binomedev\SeoPanel;


abstract class Inspector implements CanInspect
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
