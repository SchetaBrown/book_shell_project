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

        if (!Auth::check()) {
            return redirect()->route('login.create')->with('warning', 'Войдите в систему');
        }

        $auth_user = Auth::user()->with(['role'])->where('email', auth()->user()->email)->first();
        if ($auth_user->role->slug !== $admin_role->slug) {
            return redirect()->back()->with('warning', 'Повысьте уровень доступа');
        }

        return $next($request);
    }
}
