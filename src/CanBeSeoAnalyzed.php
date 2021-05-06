<?php


namespace Binomedev\SeoPanel;

use Illuminate\Database\Eloquent\Model;

/**
 * Interface CanBeSeoAnalyzed
 * @package Binomedev\SeoPanel
 * @mixin Model
 */
interface CanBeSeoAnalyzed
{
    public function seoMeta();

    public function getSeoField($field);

    public function getSeoAttribute($field);
}
