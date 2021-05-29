<?php


namespace Binomedev\SeoPanel\Jobs;


use Binomedev\SeoPanel\Sorcery;

class LinkRequest extends Job
{
    public function handle(Sorcery $sorcery)
    {
        $sorcery->post('/link');
    }
}
