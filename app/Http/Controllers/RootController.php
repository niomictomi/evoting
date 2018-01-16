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
        $this->middleware('ajax');
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

    public function passwordCheck(Request $request)
    {
        if(Hash::check($request->password, Auth::user()->password)) {
            return response()->json([
                'success' => 1
            ]);
        }

        return response('Forbidden Access !', 403);
    }  

}
