<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth('sanctum')->user() &&  auth('sanctum')->user()->is_admin == 1) {
            return $next($request);
        }

        return response()->json(['status'=> false,'error' => 'Forbidden. The user is authenticated, but does not have the permissions to perform an action.'], 403);
    }
}
