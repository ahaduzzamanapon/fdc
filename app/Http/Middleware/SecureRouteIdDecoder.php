<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SecureRouteIdDecoder
{
    /**
     * Handle an incoming request.
     * Decodes any hashed/encrypted route parameters (especially for DELETE, PUT, GET)
     * so that controllers receive the decoded numeric ID safely.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $route = $request->route();

        if ($route) {
            $parameters = $route->parameters();

            foreach ($parameters as $key => $value) {
                if (is_string($value) && !is_numeric($value)) {
                    $decoded = decode_secure_hash_id($value);
                    if ($decoded !== null) {
                        $route->setParameter($key, $decoded);
                    }
                }
            }
        }

        return $next($request);
    }
}
