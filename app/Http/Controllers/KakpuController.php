<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        return view('admin.kakpu.bukasuara');
    }

    public function save( Request $request)
    {
        $this->validate($request, [
            'helper' => 'required',
        ]);
        $user = User::find($request->id);
        if(!Hash::check($request->helper, Auth::user()->password)) {
            return back()->with([
                'error' => 'Kata sandi anda salah !'
            ]);
        }else{
            $user->update([
                'helper' =>$request->helper,
            ]);
            return back()->with([
                'message' => 'Password telah disimpan'
            ]);
        }

    }

}
