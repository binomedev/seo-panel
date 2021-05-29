<?php


namespace Binomedev\SeoPanel\Commands;


use Binomedev\SeoPanel\Jobs\PingRequest;
use Binomedev\SeoPanel\Sorcery;

class PingCommand extends Command
{
    public $signature = 'seo:ping';

    public $description = 'Pings the server';

    public function handle(Sorcery $sorcery)
    {
        $result = $sorcery->request()->get('/ping')->ok();

        $this->comment($result);
    }
}
