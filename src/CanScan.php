<?php


namespace Binomedev\SeoPanel;


interface CanScan
{
    function scan(CanBeSeoAnalyzed $model): Report;
}
