<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Support\Role;

class PengecekanHakAkses
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param string $hakakses
     * @return mixed
     */
    public function handle($request, Closure $next, $hakakses)
    {
        // Jika hakakses yang diminta tidak sesuai dengan
        // hak akses pada user yang sedang login, maka
        // akan dialihkan ke halaman 403 (Forbidden Access)
        // serta jika hak akses yang diminta tidak ada pada
        // daftar hak akses, maka akan dialihkan ke 403 juga

        if(Auth::guard('mhs')->check()) {
            if($hakakses !== 'mhs')
                return redirect()->route('mahasiswa.login');
        }
        else if(Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();
            
            if(!in_array($hakakses, Role::ALL) ||
            (!$user->isPanitia() && $hakakses === Role::PANITIA) ||
            (!$user->isRoot() && $hakakses === Role::ROOT) ||
            (!$user->isKetuaKPU() && $hakakses === Role::KETUA_KPU) ||
            (!$user->isDosen() && $hakakses === Role::DOSEN) ||
            (!$user->isWD3() && $hakakses === Role::WD3)
            )
                return redirect()->route('admin.login.form');
        }
        else {
            if($hakakses === 'mhs')
                return redirect()->route('mahasiswa.login');
            else
                return redirect()->route('admin.login.form');
        }

        return $next($request);
    }
    
}
