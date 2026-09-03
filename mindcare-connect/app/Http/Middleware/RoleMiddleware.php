<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if(!Auth::check() || !in_array(Auth::user()->role, $roles)){
            abort(403, 'Unauthorized Access: You do not have permission to view this page');
        }

        if(!$request ->user() || !in_array($request->user()->role, $roles)){
            abort(403, 'Unauthorized Action.');
        }
        return $next($request);
    }
}
