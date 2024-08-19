<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use App\Models\Breadcrumb;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $breadcrumbs = null;
        $currentBreadcrumb = null;
        
        $user = $request->user();

        if(Auth::check()) {
            $breadcrumbs = Breadcrumb::where('for_admin', Auth::user()->isAdmin)
                                        ->where('name', '!=', 'Profile')
                                        ->where('level', '<=', '1')
                                        ->with(['children' => function ($query) {
                                            $query->with('children'); // Load the second level of children
                                        }])
                                        ->orderBy('name')
                                        ->get();

            $currentBreadcrumb = null;
    
            if ($routeName = Route::currentRouteName()) {
                $currentBreadcrumb = Breadcrumb::where('href', $routeName)->first();
                if ($currentBreadcrumb) {
                    $currentBreadcrumb->load('parent');
                }
            }
        }

        if ($user) {
            $user->load([
                'employee.department' => function ($query) {
                    $query->with('parent');
                },
                'employee.designation'
            ]);

            $departmentAncestors = $user->employee && $user->employee->department ? $user->employee->department->ancestors() : collect([]);
            $experience = $user->employee ? $user->employee->experience() : null;
        }

        return [
            ...parent::share($request),
            'auth' => [
                'user' => $user,
                'departmentAncestors' => $departmentAncestors ?? null,
                'experience' => $experience ?? null,
            ],
            'flash' => [
                'message' => session('message'),
                'status'  => session('status'),
            ],
            'breadcrumbs' => $breadcrumbs,
            'currentBreadcrumb' => $currentBreadcrumb ? [
                'breadcrumb' => $currentBreadcrumb,
                'ancestors' => $currentBreadcrumb->ancestors(),
            ] : null,
        ];
    }
}
