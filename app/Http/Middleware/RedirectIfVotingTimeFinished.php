<?php

namespace App\Http\Middleware;

use Closure;
use App\Pengaturan;

class RedirectIfVotingTimeFinished
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
        if(Pengaturan::isVotingTelahBerlangsung())
            return abort(404);

        return $next($request);
    }

}
