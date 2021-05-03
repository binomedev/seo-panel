<?php


namespace Binomedev\SeoPanel;

interface CanScan
{
    public function scan(CanBeSeoAnalyzed $model): Report;
}
