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
            if($guard == 'mhs')
                return redirect()->route('mahasiswa.halaman.voting');
            else if($guard == 'web') {
                if(Auth::user()->isAdmin())
                    return redirect()->route('admin.dashboard');
                else if(Auth::user()->isDosen())
                    return redirect()->route('admin.dashboard');
                else if(Auth::user()->isPanitia())
                    return redirect()->route('admin.dashboard');
                else if(Auth::user()->isRoot())
                    return redirect()->route('root.dashboard');
            }
                
            return abort(403, 'Forbidden Access !');
        }

        return $next($request);
    }
}
