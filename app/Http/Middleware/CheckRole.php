<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // dd($request);

        if (Auth::check()) {
            $user = Auth::user();

            // dd($user->role);

            if ($user->role === 'master') {
                return $next($request);
            }

            return redirect()->route('record.index');
        }

        return redirect()->route('login');
    }
}
