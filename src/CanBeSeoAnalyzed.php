<?php


namespace Binomedev\SeoPanel;


interface CanBeSeoAnalyzed
{
    function seoMeta();
    function getSeoField($field);
}
