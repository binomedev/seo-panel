<?php


namespace Binomedev\SeoPanel\Inspectors;


use Binomedev\SeoPanel\Inspector;
use Binomedev\SeoPanel\Report;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Http;

class HttpsInspector extends Inspector
{

    function inspect(): Report
    {
        $report = new Report('Https Inspector');

        try {
            Http::get(url()->secure('/'));
        } catch (RequestException $exception) {
            return $report->status($passed = false)
                ->message('HTTPS not configured.')
                ->help('You should generate an SSL certificate using Let\'s Encrypt. ')
               ;
        }

        return $report->status($passed = true)->message('Connection is secure.');
    }
}
