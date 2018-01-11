<?php

namespace App\Http\Middleware;

use Closure;

class AjaxRequest
{
    /**
     * Melakukan pengecekan jika sebuah route hanya bisa diakses
     * melalui XMLHttpRequest, jika tidak, maka dialihkan ke 
     * halaman 403 (Forbidden Access)
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->ajax())
            return $next($request);

        return abort(403, 'Anda tidak bisa mengakses halaman ini !');
    }
}
