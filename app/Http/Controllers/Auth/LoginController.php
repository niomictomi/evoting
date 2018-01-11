<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Voting\Http\Controllers\Controller;
use App\User;
use App\Mahasiswa;

class LoginController extends Controller
{

    /**
     * Melakukan proses login untuk seluruh user, kecuali
     * mahasiswa
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|numeric',
            'password' => 'required'
        ]);

        $request->remember = (is_null($request->remember)) ? false : $request->remember;
        if (Auth::attempt(['id' => $request->id, 'password' => $request->password], $request->remember)){
            if (Auth::user()->isRoot()){
                return redirect()->route('root.dashboard');
            }
            if (Auth::user()->isAdmin()){
                return redirect()->route('admin.dashboard');
            }
            if (Auth::user()->isDosen() || Auth::user()->isWD1()){
                return redirect()->route('dosen.dashboard');
            }
            if (Auth::user()->isKetuaKPU()){
                return redirect()->route('kakpu.dashboard');
            }
            if (Auth::user()->isPanitia()){
                return redirect()->route('panitia.dashboard');
            }
        }

        return back()->with('message', 'NIP/NIM atau password salah!');
    }

    /**
     * Melakukan proses login untuk mahasiswa
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function loginMahasiswa(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|numeric',
            'password' => 'required'
        ]);

        if ($request->password == Carbon::today()->toDateString()){
            try {
                $mahasiswa = Mahasiswa::findOrFail($request->id);
            }
            catch(ModelNotFoundException $err) {
                return back()->with('message', 'NIM Salah');
            }

            if(!$mahasiswa->bisa_memilih)
                return back()->with('message', 'Akun anda belum diaktivasi !');

            Auth::guard('mhs')->login($mahasiswa);
            return redirect()->route('mahasiswa.halaman.voting');
        } else {
            return back()->with('message', 'Password salah!');
        }
    }

    /**
     * Proses logout untuk seluruh user dan mahasiswa
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        if(Auth::guard('web')->check()) {
            Auth::logout();
            return redirect()->route('admin.login.form');
        }
        else if(Auth::guard('mhs')->check()) {
            Auth::guard('mhs')->logout();
            return redirect()->route('mahasiswa.login');
        }
    }

    public function form()
    {
        if (Auth::check()){
            return back();
        }
        return view('admin.login');
    }

}
