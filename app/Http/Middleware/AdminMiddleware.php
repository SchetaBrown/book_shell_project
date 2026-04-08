<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $admin_role = Role::where('slug', 'admin')->first();
        $auth_user = Auth::user()->with(['role']);

        if ($auth_user->role->title !== $admin_role->title) {
            return redirect()->back()->with('warning', 'Повысьте уровень доступа');
        }

        return $next($request);
    }
}
