<?php

namespace App\Http\Controllers;

use App\Mahasiswa;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Wd3dosenController extends Controller
{
    public function __construct()
    {

    }

    /**
     * Menampilkan halaman dashboard DOsen dan Wd 3
     * nama routes : dosen.dashboard
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
        return view('admin.wd3dosen.dashboard', [
            'mhs' => $mhs->count(),
            'mhsaktif' => $mhs_aktif->count(),
            'mhscuti' => $mhs_cuti->count(),
            'mhsnonaktif' => $mhs_nonaktif->count(),
            'tipe' => $request->tipe,
            'hasil' => $request->hasil
        ]);

    }

    public function buka()
    {
        $wd3 = User::where('role', '=', 'wd3')->where('helper', '!=', null)->count();
        //dd($wd3);
        return view('admin.wd3dosen.bukasuara', compact('wd3'));
    }

    public function save(Request $request)
    {
        $this->validate($request, [
            'helper' => 'required',
        ]);
        $pass = $request->helper;
        $password = bcrypt($pass);

        $user = User::find($request->id);

        $user->update([
            'helper' =>$password,
        ]);
        return back()->with([
            'message' => 'Password : '.$pass
        ]);


    }
}
