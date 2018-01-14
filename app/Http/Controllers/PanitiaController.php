<?php

namespace App\Http\Controllers;

use App\Mahasiswa;
use Illuminate\Http\Request;


class PanitiaController extends Controller
{
    public function __construct()
    {

    }

    /**
     * Menampilkan halaman dashboard panitia
     * nama routes : panitia.dashboard
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.panitia.dashboard');
    }

    public function paslon()
    {
        return view('admin.panitia.paslon');
    }

    public function paslonform()
    {
        return view('admin.panitia.form');
    }

    public function resepsionis()
    {
        $result = Mahasiswa::orderBy('id', 'DESC')->get();
        return view('admin.panitia.resepsionis', compact('result'));
    }

    public function carimhs(Request $request)
    {
        if ($request->has('id')) {
            $key = $request->id;
            $result = Mahasiswa::whereRaw('("id" LIKE \'%' . $key . '%\')')->get();
        }
        //$mhscari = Mahasiswa::where('id','=',$request->id)->get();
        //dd($result);
        return view('admin.panitia.resepsionis', compact('result'));
    }

    public function updatestatus(Request $request)
    {
        $this->validate($request, [
            'login' => 'required',
        ]);
        $mahasiswa = Mahasiswa::find($request->id);

        if ($mahasiswa->status=='A')
        {
            $mahasiswa->update([
                'login' => $request->login,
            ]);
            return back()->with('message', 'Akun Mahasiswa ' . $mahasiswa->id . ' berhasil diaktifkan');
        }
        else{
            return back()->with('message', 'Mahasiswa Berstatus Cuti / Non-aktir');
        }


    }

}
