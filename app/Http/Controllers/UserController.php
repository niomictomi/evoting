<?php

namespace App\Http\Controllers;

use App\Support\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('bukanmhs');
    }
    
    /**
     * Mengubah profil user
     * route: admin.pengaturan
     *
     * @param Request $request
     * @return Illuminate\Http\RedirectResponse
     */
    public function pengaturan(Request $request)
    {
        $arrValidation = [
            'nama' => 'required'
        ];

        if(Auth::user()->isRoot())
            $arrValidation['id'] = 'required|numeric|unique:users,id,'.Auth::user()->id;

        $this->validate($request, $arrValidation);

        Auth::user()->update([
            'nama' => $request->nama
        ]);

        if(Auth::user()->isRoot()) {
            Auth::user()->update([
                'id' => $request->id
            ]);
        }

        return back()->with([
            'success' => 'Berhasil mengubah profil !'
        ]);
    }

    /**
     * Mengubah kata sandi user
     * route: admin.ubah.password
     *
     * @param Request $request
     * @return Illuminate\Http\RedirectResponse
     */
    public function ubahPassword(Request $request)
    {  
        if(!Hash::check($request->passlama, Auth::user()->password)) {
            return back()->with([
                'error' => 'Kata sandi lama anda salah !'
            ]);
        }
        else {
            if($request->passbaru !== $request->passbaru_confirmation) {
                return back()->with([
                    'error' => 'Kata sandi yang anda masukkan tidak sama !'
                ]); 
            }
            else {
                if (Auth::user()->role == Role::KETUA_KPU){
                    Auth::user()->update([
                        'password' => bcrypt($request->passbaru),
                        'helper' => bcrypt($request->passbaru)
                    ]);
                } else {
                    Auth::user()->update([
                        'password' => bcrypt($request->passbaru)
                    ]);
                }

                return back()->with([
                    'success' => 'Berhasil mengubah kata sandi 1 !'
                ]);
            }
        }
    }

}
