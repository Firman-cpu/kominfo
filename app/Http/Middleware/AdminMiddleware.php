<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->session()->has('admin_id')) {
            return redirect()
                ->route('admin.login')
                ->withErrors([
                    'auth' => 'Silakan login terlebih dahulu.',
                ]);
        }

        return $next($request);
    }
}