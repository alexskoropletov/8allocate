<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class LogApiRequest
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
        Log::info(
            sprintf(
                '[%s] API Request to %s',
                $request->method(),
                $request->url()
            ),
            $request->all()
        );
        return $next($request);
    }
}
