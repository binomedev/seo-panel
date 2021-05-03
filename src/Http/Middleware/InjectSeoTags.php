<?php


namespace Binomedev\SeoPanel\Http\Middleware;


use Binomedev\SeoPanel\Seo;
use Closure;
use Exception;
use Illuminate\Http\Request;


class InjectSeoTags
{
    /**
     * The URIs that should be excluded.
     *
     * @var array
     */
    protected $except = [];

    protected $seo;
    protected $enabled = true;

    public function __construct(Seo $seo)
    {
        $this->seo = $seo;
        $this->enabled = config('seo.auto_inject_enabled');
        $this->except = config('seo.inject_except') ?: [];
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($this->canSkipInject($request)) {
            return $next($request);
        }

        // It's time for some sorcery
        try {
            /** @var \Illuminate\Http\Response $response */
            $response = $next($request);
        } catch (Exception $e) {
            $response = $this->handleException($request, $e);
        }

        $this->seo->modifyResponse($request, $response);

        return $response;
    }

    private function canSkipInject($request) : bool
    {
        return !$request->isMethod('get')
            || !$this->enabled
            || $request->expectsJson()
            || $this->inExceptArray($request);
    }

    /**
     * Determine if the request has a URI that should be ignored.
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    protected function inExceptArray($request)
    {
        foreach ($this->except as $except) {
            if ($except !== '/') {
                $except = trim($except, '/');
            }

            if ($request->is($except)) {
                return true;
            }
        }

        return false;
    }
}
