<?php

namespace App\Http\Middleware;

use Closure;
use App\Pengaturan;

class RedirectIfVotingTimeNotYetStarted
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!Pengaturan::isVotingSedangBerlangsung())
            return redirect()->route('votingbelummulai');

        return $next($request);
    }

}
