<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * @param  list<string>  $roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        abort_unless(
            $request->user()
                && array_diff($roles, User::ROLES) === []
                && in_array($request->user()->role, $roles, true),
            Response::HTTP_FORBIDDEN,
        );

        return $next($request);
    }
}
