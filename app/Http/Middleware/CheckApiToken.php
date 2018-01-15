<?php

namespace App\Http\Middleware;

use Closure;
use App\ApiToken;

class CheckApiToken
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
        $token = ApiToken::where('public', $request->input('public'))->first();
        if ($token && $token->isValid($request->input('token'))) {
            return $next($request);
        }

        return false;
    }
}
