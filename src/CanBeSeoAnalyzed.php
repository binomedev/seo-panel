<?php


namespace Binomedev\SeoPanel;

interface CanBeSeoAnalyzed
{
    public function seoMeta();

    public function getSeoField($field);

    public function getSeoAttribute($field);
}
