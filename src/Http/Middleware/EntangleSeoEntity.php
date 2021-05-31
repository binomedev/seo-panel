<?php

namespace Binomedev\SeoPanel\Http\Middleware;


use Binomedev\SeoPanel\SeoFacade;
use Closure;
use CodrinAxinte\SorceryCore\Contracts\CanBeSeoAnalyzed;
use Illuminate\Http\Request;

class EntangleSeoEntity
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->isMethod('get') || $request->expectsJson()) {
            return $next($request);
        }

        $params = $request->route()->parameters();

        $entity = $this->getEntity($params);

        if (!$entity) {
            return $next($request);
        }

        SeoFacade::entangle($entity);

        return $next($request);
    }

    private function getEntity($params): ?CanBeSeoAnalyzed
    {
        foreach ($params as $param) {
            // Get the first bound seo analyzable model
            if ($param instanceof CanBeSeoAnalyzed) {
                return $param;
            }
        }

        return null;
    }
}
