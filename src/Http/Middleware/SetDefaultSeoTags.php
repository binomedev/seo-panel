<?php


namespace Binomedev\SeoPanel\Http\Middleware;


use Artesaos\SEOTools\Contracts\SEOTools;
use Binomedev\SeoPanel\Seo;
use Illuminate\Http\Request;

class SetDefaultSeoTags
{

    private $seo;
    private $seoTools;

    /**
     * SetGlobalSeoTags constructor.
     * @param $seo
     * @param $seoTools
     */
    public function __construct(Seo $seo, SEOTools $seoTools)
    {
        $this->seo = $seo;
        $this->seoTools = $seoTools;
    }


    public function handle(Request $request, \Closure $next)
    {
        if (!$request->isMethod('get') || $request->expectsJson()) {
            return $next($request);
        }

        // TODO: This should be cached
        $options = $this->seo->options();

        $this->seoTools->metatags()->setTitleDefault($options->get('title', config('app.name')));
        $this->seoTools->metatags()->setTitleSeparator(' ' . $options->get('title_separator', '-') . ' ');
        $this->seoTools->setDescription($options->get('description'));

        return $next($request);
    }
}
