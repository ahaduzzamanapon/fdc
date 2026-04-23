<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticateMultiGuard
{
   public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('web')->check() || Auth::guard('producer')->check()) {
            return $next($request);
        }

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        // producer login এ redirect
        $type = session('login_type', 'citizen');
        if (!in_array($type, ['admin', 'citizen'])) {
            $type = 'citizen';
        }

        return redirect()->route('login.custom', [ 'type' => $type ]);
    }


}
