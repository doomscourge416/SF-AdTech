<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminRole
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        if (auth()->user()?->role !== 'admin') {
            abort(403, 'Доступ запрещён — только администратор может просматривать эту страницу');
        }

        return $next($request);
    }
}
