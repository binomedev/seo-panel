<?php

namespace Binomedev\SeoPanel;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Binomedev\SeoPanel\Seo
 * @mixin Seo
 */
class SeoFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Seo::class;
    }
}
