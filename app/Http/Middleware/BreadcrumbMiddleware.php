<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Breadcrumb;
use Illuminate\Support\Facades\Route;

class BreadcrumbMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $routeName = Route::currentRouteName();
        $breadcrumb = Breadcrumb::where('href', $routeName)->first();

        if ($breadcrumb) {
            $breadcrumb->load('parent'); // Eager load the parent
            $ancestors = $breadcrumb->ancestors();
            $breadcrumb->ancestors = $ancestors; // Attach ancestors to the breadcrumb
            $request->merge(['breadcrumb' => $breadcrumb]);
        }

        return $next($request);
    }
}
