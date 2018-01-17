<?php

namespace App\Http\Controllers;

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
    public function index()
    {
      return view('admin.wd3dosen.dashboard');
    }

    public function buka()
    {
      return view('admin.wd3dosen.bukasuara');
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
