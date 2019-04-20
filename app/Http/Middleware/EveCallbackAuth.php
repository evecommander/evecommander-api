<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Laravel\Passport\TokenRepository;

class EveCallbackAuth
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request          $request
     * @param \Closure                          $next
     * @param \Laravel\Passport\TokenRepository $repository
     *
     * @return mixed
     */
    public function handle($request, Closure $next, TokenRepository $repository)
    {
        $user = null;

        if ($request->has('state')) {
            /** @var User $user */
            $user = $repository->find($request->get('state'))->user()->first();
            auth()->login($user);
        }

        if (is_null($user)) {
            return response('Invalid state parameter', 401);
        }

        return $next($request);
    }
}
