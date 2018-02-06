<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use App\User;
use App\Mahasiswa;

class LoginController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest:web')->only(['login', 'form']);
        $this->middleware('guest:mhs')->only('loginMahasiswa');
    }

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
            'id' => 'required',
            'password' => 'required'
        ]);

        $request->remember = (is_null($request->remember)) ? false : $request->remember;

        try {
            $user = User::findOrFail($request->id);

            if(!Hash::check($request->password, $user->password)) {
                return back()->with([
                    'error' => 'NIM/NIP atau kata sandi salah'
                ]);
            }

            // mengecek apakah user sudah pernah login
            // mencegah satu akun di buka pada pc atau laptop lain
            if($this->userActive($user)) {
                return back()->with([
                    'error' => 'Akun ini telah masuk pada perangkat lain'
                ]);
            }

            Auth::login($user);
            Auth::user()->update([
                'last_active' => Carbon::now()
            ]);;

            if (Auth::user()->isRoot()) {
                return redirect()->route('root.dashboard');
            }
            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin.dashboard', ['tipe' => 'bem']);
            }
            if (Auth::user()->isDosen() || Auth::user()->isWD3()) {
                return redirect()->route('dosen.dashboard');
            }
            if (Auth::user()->isKetuaKPU()) {
                return redirect()->route('kakpu.dashboard');
            }
            if (Auth::user()->isPanitia()) {
                return redirect()->route('panitia.dashboard');
            }

        }
        catch (ModelNotFoundException $e) {
            return back()->with([
                'error' => 'NIM/NIP atau kata sandi salah'
            ]);
        }
    }

    /**
     * Mengecek apakah user sedang aktif
     * Hal ini mencegah satu akun dibuka pada device yang berbeda
     *
     * @param User $user
     * @return bool
     */
    protected function userActive(User $user)
    {
        if(is_null($user->last_active))
            return false;
        else {
            // jika last active null, maka dicek jarak
            // perbedaan waktunya
            if(Carbon::now()->diffInHours(Carbon::parse($user->last_active)) < 24)
                return true;
        }

        return true;
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

        try {
            $mahasiswa = Mahasiswa::findOrFail($request->id);

            // jika akun mahasiswa telah diaktivasi
            if($mahasiswa->login) {
                // jika mahasiswa belum pernah login
                if(!$mahasiswa->telah_login) {
                    // Mengecek status mahasiswa
                    if($mahasiswa->isMahasiswaAktif()) {
                        // Pengecekan password
                        if(Hash::check($request->password, $mahasiswa->password)) {
                            Auth::guard('mhs')->login($mahasiswa);
                            $mahasiswa->telah_login = true;
                            $mahasiswa->save();

                            // mengeset timer
                            session()->put('timer-end', Carbon::now()->addMinutes(5));

                            return redirect()->route('mahasiswa.halaman.voting');
                        }
                        else {
                            return back()->with([
                                'error' => 'Maaf, kata sandi salah !'
                            ]);
                        }
                    }
                    else {
                        return back()->with([
                            'error' => 'Maaf, anda bukan mahasiswa aktif !'
                        ]);
                    }
                }
                else {
                    return back()->with([
                        'error' => 'Maaf, anda tidak bisa login kembali !'
                    ]);
                }
            }
            else {
                return back()->with([
                    'error' => 'Akun anda belum diaktivasi !'
                ]);
            }
        } catch(ModelNotFoundException $e) {
            return back()->with([
                'error' => 'NIM tidak terdaftar !'
            ]);
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
            Auth::user()->update([
                'last_active' => null
            ]);

            Auth::logout();
            return redirect()->route('admin.login.form');
        }
        else if(Auth::guard('mhs')->check()) {
            // menghapus timer
            session()->forget('timer-end');
            Auth::guard('mhs')->logout();
            return redirect()->route('mahasiswa.login');
        }

        return redirect()->route('mahasiswa.login');
    }

    public function form()
    {
        if (Auth::check()){
            return back();
        }
        return view('admin.login');
    }

}
