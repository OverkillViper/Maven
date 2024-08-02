<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        switch ($role) {
            case 'admin':
                if(auth()->check() && auth()->user()->isAdmin == 1){
                    return $next($request);
                } else {
                    return abort(403,'Access Denied');
                }
            case 'employee':
                if(auth()->check() && auth()->user()->isAdmin == 0){
                    return $next($request);
                } else {
                    return abort(403,'Access Denied');
                }
            default:
                return abort(403,'Access Denied');
        }
        
    }
}
