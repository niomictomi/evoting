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
