<?php


namespace Binomedev\SeoPanel;


use Binomedev\SeoPanel\Models\NotFoundLog;
use Illuminate\Http\Response;
use Throwable;

class NotFoundMonitor
{
    public static function handle(Throwable $e)
    {
        if($e->getCode() !== Response::HTTP_NOT_FOUND){
            return;
        }

        $request = request();
        $record = NotFoundLog::firstOrCreate([
            'uri' => $request->getUri(),
            'ip' => $request->getClientIp(),
            'user_agent' => $request->userAgent()],
        [
            'referer' => url()->previous(),
        ]);

        $record->increment('hits');
    }
}
