<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class KeycloakAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $KCloakSession = session('_keycloak_session');
        $KCloakToken = $KCloakSession ? json_decode($KCloakSession)->access_token : null;
        if (!$KCloakToken) {
            return redirect()->route('login');
        }
        return $next($request);
    }
}
