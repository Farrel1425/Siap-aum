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
    public function handle(Request $request, Closure $next, $roles): Response
    {
        if ($roles == 'admin' && auth()->user()->isAdmin) {
            return $next($request);
        } else if ($roles == 'public' && auth()->user()->isOperator) {
            return $next($request);
        } else {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses untuk aksi tersebut');
        }
    }
}
