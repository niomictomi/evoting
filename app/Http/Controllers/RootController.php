<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Mahasiswa;
use App\CalonHMJ;
use App\CalonDPM;
use App\CalonBEM;
use App\User;
use App\Support\Role;

class RootController extends Controller
{

    public function __construct()
    {
        $this->middleware('ajax')->except(['bukaAkun']);
    }

    /**
     * Melakukan reset database
     *
     * @return Illuminate\Http\JsonResponse
     */
    public function reset()
    {
        foreach(CalonHMJ::all() as $calon)
            $calon->getPemilih()->detach();

        CalonHMJ::getQuery()->delete();

        foreach(CalonBEM::all() as $calon)
            $calon->getPemilih()->detach();
        
        CalonBEM::getQuery()->delete();        

        foreach(CalonDPM::all() as $calon) 
            $calon->getPemilih()->detach();
        
        CalonDPM::getQuery()->delete();        

        Mahasiswa::getQuery()->delete();

        User::where('role', '!=', Role::ROOT)->delete();

        return response()->json([
            'success' => 'Berhasil mereset database !'
        ]);
    }

    /**
     * Melakukan pengecekan password untuk konfirmasi reset database
     *
     * @param Request $request
     * @return mixed
     */
    public function passwordCheck(Request $request)
    {
        if(Hash::check($request->password, Auth::user()->password)) {
            return response()->json([
                'success' => 1
            ]);
        }

        return response('Forbidden Access !', 403);
    }
    
    /**
     * Mengaktifkan akun mahasiswa
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function bukaAkun(Request $request)
    {
        $mahasiswa = Mahasiswa::find($request->nim);

        $mahasiswa->telah_login = false;
        $mahasiswa->save();

        return back()->with([
            'success' => 'Berhasil mengaktifkan akun !'
        ]);
    }

}
