<?php


namespace Binomedev\SeoPanel\Jobs;


use Binomedev\SeoPanel\Sorcery;

class PingRequest extends Job
{

    public function handle(Sorcery $sorcery)
    {
       return $sorcery->request()->get('/ping')->ok();
    }
}
