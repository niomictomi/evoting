<?php

namespace App\Http\Middleware;

use Closure;

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
        if(!Pengaturan::isVotingTelahBerlangsung())
            return redirect()->route('votingbelummulai');

        return $next($request);
    }

}
