<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login.create')->with('warning', 'Войдите в систему');
        }

        if (!auth()->user()->isAdmin()) {
            return redirect()->back()->with('warning', 'Повысьте уровень доступа');
        }

        return $next($request);
    }
}
