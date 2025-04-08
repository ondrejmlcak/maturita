<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckUserRole
{
    public function handle(Request $request, Closure $next, string $role)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        if (auth()->user()->usertype === 'admin') {
            return $next($request);
        }

        $userRole = auth()->user()->usertype;
        $allowedRoles = explode(',', $role);

        if (!in_array($userRole, $allowedRoles)) {
            if ($userRole === 'editor') {
                return redirect('/admin/dashboard');
            }

        }
        if (!in_array($userRole, $allowedRoles)) {
            return redirect('/dashboard');
        }

        return $next($request);
    }
}
