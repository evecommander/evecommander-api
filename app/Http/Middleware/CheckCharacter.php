<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class CheckCharacter
{
    const CHARACTER_HEADER = 'X-Character';

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // The X-Character header must be present
        if (!$request->hasHeader(self::CHARACTER_HEADER)) {
            return response()->json([
                'errors' => [
                    [
                        'title'  => 'Missing character concerned in request',
                        'detail' => 'A character was not included in the attempted request when one must be',
                    ],
                ],
            ], 401);
        }

        /** @var User $user */
        $user = $request->user();

        // The X-Character header must be valid for the authenticated user
        if (!$user->characters()->where('characters.id', '=', $request->header(self::CHARACTER_HEADER))->exists()) {
            return response()->json([
                'errors' => [
                    [
                        'title'  => 'Invalid Character',
                        'detail' => 'The character assigned to the request is not associated with the authenticated user',
                    ],
                ],
            ], 403);
        }

        return $next($request);
    }
}
