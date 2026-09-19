<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserCanAccess
{
    public function handle(Request $request, Closure $next, string $module): Response
    {
        /** @var User|null $user */
        $user = Auth::user();

        if (!$user || !$user->canAccess($module)) {
            abort(403, 'No tienes permiso para acceder a este módulo.');
        }

        return $next($request);
    }
}