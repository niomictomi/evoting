<?php

namespace App\Http\Controllers;

use App\Mahasiswa;
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
    public function index(Request $request)
    {
        if (!in_array($request->tipe, ['bem', 'dpm', 'hmj']))
            if (!in_array($request->hasil, ['bem', 'dpm', 'hmj']))
                $request->tipe = 'bem';
        $request->hasil = 'bem';
        $mhs = Mahasiswa::all();
        $mhs_aktif = Mahasiswa::getByStatus();
        $mhs_cuti = Mahasiswa::getByStatus([Mahasiswa::CUTI]);
        $mhs_nonaktif = Mahasiswa::getByStatus([Mahasiswa::NONAKTIF]);
        return view('admin.kakpu.dashboard', [
            'mhs' => $mhs->count(),
            'mhsaktif' => $mhs_aktif->count(),
            'mhscuti' => $mhs_cuti->count(),
            'mhsnonaktif' => $mhs_nonaktif->count(),
            'tipe' => $request->tipe,
            'hasil' => $request->hasil
        ]);
    }

    public function buka(Request $request)
    {
        if (!in_array($request->hasil, ['bem', 'dpm', 'hmj']))
            $request->hasil = 'bem';

        $users = User::whereIn('role', [Role::KETUA_KPU, Role::DOSEN, Role::WD3])->get();

        return view('admin.kakpu.bukasuara', [
            'users' => $users,
            'hasil' => $request->hasil
        ]);
    }

    public function save(Request $request)
    {
        if (!Pengaturan::checkJikaSemuaPasswordBukaHasilTelahDiisiKetuaKpu()) {
            $user = User::find($request->id);
            if (Hash::check($request->password, $user->helper)) {
                $user->helper = 'secret';
                $user->save();
            } else {
                return back()->with('error', 'Kata sandi anda salah!');
            }
            if (Pengaturan::checkJikaSemuaPasswordBukaHasilTelahDiisiKetuaKpu()) {
                Pengaturan::find('buka_hasil')->update(['value' => true]);
                return back()->with('message', 'Kotak suara telah dibuka!');
            }
            return back()->with('message', 'Password telah sesuai.');
        }
        return back()->with('message', 'Anda telah menginputkan semua password dan kotak suara bisa dibuka.');
    }

    public function printhasil(Request $request)
    {

        if($request->hasil == 'bem'){
            return view('admin.kakpu.include.print', [

                'hasil' => 'BEM'
            ]);
        }
        elseif ($request->hasil == 'dpm'){
            return view('admin.kakpu.include.print', [

                'hasil' => 'DPM'
            ]);
        }
        elseif ($request->hasil == 'hmj'){
            return view('admin.kakpu.include.print', [

                'hasil' => 'HMJ'
            ]);
        }
        else
            return back()->with('error', 'pilihan tidak tersedia');

    }


}
