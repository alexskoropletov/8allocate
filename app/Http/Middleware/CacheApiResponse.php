<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;

class CacheApiResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $key = sprintf(
            'caching-%s-%s-%s',
            $request->method(),
            $request->url(),
            implode('.', $request->all())
        );
        if (!$response = Cache::get($key)) {
            $response = $next($request);
            Cache::put($key, $response, config('cache.file.expires_at', 60));
        }

        return $response;
    }
}
