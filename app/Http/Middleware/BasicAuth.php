<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BasicAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only apply in non-production/non-local environments
        if (in_array(app()->environment(), ['production', 'local'])) {
            return $next($request);
        }

        $USERNAME = config('auth.basic.user');
        $PASSWORD = config('auth.basic.pass');

        return $request->getUser() === $USERNAME &&
            $request->getPassword() === $PASSWORD
            ? $next($request)
            : response('Unauthorized', 401)
            ->header('WWW-Authenticate', 'Basic realm="UAT Access"');
    }
}
