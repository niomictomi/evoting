<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            if($guard == 'mahasiswa')
                return redirect()->route('mahasiswa.halaman.voting');
            else if($guard == 'web')
                return redirect('/home');
                
            return abort(403, 'Forbidden Access !');
        }

        return $next($request);
    }
}
