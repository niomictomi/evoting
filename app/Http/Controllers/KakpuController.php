<?php

namespace App\Http\Controllers;

use App\Pengaturan;
use App\Support\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class KakpuController extends Controller
{
    public function __construct()
    {

    }

    /**
     * Menampilkan halaman dashboard Ketua KPU
     * nama routes : kakpu.dashboard
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.kakpu.dashboard');
    }

    public function buka()
    {
        $users = User::whereIn('role', [Role::KETUA_KPU, Role::DOSEN, Role::WD3])->get();

        return view('admin.kakpu.bukasuara', [
            'users' => $users
        ]);
    }

    public function save(Request $request)
    {
        if (!Pengaturan::checkJikaSemuaPasswordBukaHasilTelahDiisiKetuaKpu()){
            $user = User::find($request->id);
            if (Hash::check($request->password, $user->helper)){
                $user->helper = 'secret';
                $user->save();
            }
            else{
                return back()->with('error', 'Kata sandi anda salah!');
            }
            if (Pengaturan::checkJikaSemuaPasswordBukaHasilTelahDiisiKetuaKpu()){
                Pengaturan::find('buka_hasil')->update(['value' => true]);
                return back()->with('message', 'Kotak suara telah dibuka!');
            }
            return back()->with('message', 'Password telah sesuai.');
        }
        return back()->with('message', 'Anda telah menginputkan semua password dan kotak suara bisa dibuka.');
    }

}
