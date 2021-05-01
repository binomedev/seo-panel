<?php

namespace Binomedev\SeoPanel;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Binomedev\SeoPanel\SeoPanel
 * @mixin SeoPanel
 */
class SeoPanelFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return SeoPanel::class;
    }
}
