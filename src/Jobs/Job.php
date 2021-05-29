<?php


namespace Binomedev\SeoPanel\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

abstract class Job implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected function debugResponse($response)
    {
        if(config('app.debug')){
            Log::debug('Entity Updated', ['status' => $response->status(), 'response' => $response->json()]);
        }
    }

}
