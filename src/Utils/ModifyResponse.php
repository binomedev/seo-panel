<?php


namespace Binomedev\SeoPanel\Utils;


use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Http\Response as IlluminateResponse;
use Symfony\Component\HttpFoundation\Response;

class ModifyResponse
{
    public static function handle(Response $response)
    {
        $content = $response->getContent();

        $head = SEOTools::generate(true);

        // Position the meta tags right at the beginning of the head tag.
        $tag = '<head>';
        $pos = strripos($content, $tag) + strlen($tag);
        if (false !== $pos) {
            $start = substr($content, 0, $pos);
            $end = substr($content, $pos);
            $content = $start . $head . $end;
        }

        $original = null;
        if ($response instanceof IlluminateResponse && $response->getOriginalContent()) {
            $original = $response->getOriginalContent();
        }

        $response->setContent($content);

        // Restore original response (eg. the View or Ajax data)
        if ($original) {
            $response->original = $original;
        }
    }

}
