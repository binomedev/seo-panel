<?php


namespace Binomedev\SeoPanel\Contracts;

use Binomedev\SeoPanel\Result;

interface CanScan
{
    public function scan(CanBeSeoAnalyzed $model): Result;
}
