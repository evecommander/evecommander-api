<?php

namespace App\Http\Middleware;

use Closure;

class EveCallbackAuth
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
        $user = null;

        if ($request->has('state')) {
            $user = auth()->setToken($request->get('state'))->user();
        }

        if (is_null($user)) {
            return response()->setStatusCode(401);
        }

        return $next($request);
    }
}
