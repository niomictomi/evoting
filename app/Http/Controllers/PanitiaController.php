<?php

namespace App\Http\Controllers;

use App\CalonBEM;
use App\CalonDPM;
use App\CalonHMJ;
use App\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\DataTables;


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
        $test=CalonHMJ::find(13);
        return view('admin.panitia.dashboard',compact('test'));
    }

    public function paslon()
    {


        return view('admin.panitia.paslon');
    }

    public function formhmj()
    {
        return view('admin.panitia.form');
    }

    public function hmjsave(Request $request)
    {
        $request->validate([
            'ketua_id' => 'required',
            'wakil_id' => 'required',
            'visi' => 'required',
            'misi' => 'required',
            'dir' => 'required',
        ]);

        $id = CalonHMJ::count();
        $idnow = $id + 1;


        if ($request->hasFile('dir')) {

            $fillnames2 = $request->dir->getClientOriginalName() . '' . str_random(4);
            $filename = 'upload/photo/hmj/'
                . str_slug($fillnames2, '-') . '.' . $request->dir->getClientOriginalExtension();
            $request->dir->storeAs('public', $filename);
            $berkas = new CalonHMJ();
            $berkas->dir = $filename;
            $berkas->ketua_id = $request->ketua_id;
            $berkas->wakil_id = $request->wakil_id;
            $berkas->visi = $request->visi;
            $berkas->misi = $request->misi;
            $berkas->save();
            $dir = $fillnames2;

        }

        return redirect('panitia/paslon')->with('message', 'Paslon Berhasil Ditambahkan');
    }

    public function formdpm()
    {
        return view('admin.panitia.formdpm');
    }

    public function dpmsave(Request $request)
    {
        $request->validate([
            'anggota_id' => 'required',
            'visi' => 'required',
            'misi' => 'required',
            'dir' => 'required',
        ]);

        $id = CalonHMJ::count();
        $idnow = $id + 1;


        if ($request->hasFile('dir')) {

            $fillnames2 = $request->dir->getClientOriginalName() . '' . str_random(4);
            $filename = 'upload/photo/dpm/'
                . str_slug($fillnames2, '-') . '.' . $request->dir->getClientOriginalExtension();
            $request->dir->storeAs('public', $filename);
            $berkas = new CalonDPM();
            $berkas->dir = $filename;
            $berkas->anggota_id = $request->anggota_id;
            $berkas->visi = $request->visi;
            $berkas->misi = $request->misi;
            $berkas->save();
            $dir = $fillnames2;

        }
        return redirect('panitia/paslon')->with('message', 'Paslon Berhasil Ditambahkan');
    }

    public function formbem()
    {
        return view('admin.panitia.formbem');
    }

    public function bemsave(Request $request)
    {
        $request->validate([
            'ketua_id' => 'required',
            'wakil_id' => 'required',
            'visi' => 'required',
            'misi' => 'required',
            'dir' => 'required',
        ]);

        $id = CalonHMJ::count();
        $idnow = $id + 1;


        if ($request->hasFile('dir')) {

            $fillnames2 = $request->dir->getClientOriginalName() . '' . str_random(4);
            $filename = 'upload/photo/bem/'
                . str_slug($fillnames2, '-') . '.' . $request->dir->getClientOriginalExtension();
            $request->dir->storeAs('public', $filename);
            $berkas = new CalonBEM();
            $berkas->dir = $filename;
            $berkas->ketua_id = $request->ketua_id;
            $berkas->wakil_id = $request->wakil_id;
            $berkas->visi = $request->visi;
            $berkas->misi = $request->misi;
            $berkas->save();
            $dir = $fillnames2;

        }

        return redirect('panitia/paslon')->with('message', 'Paslon Berhasil Ditambahkan');
    }

    public function api()
    {

        //$result = Mahasiswa::orderBy('id', 'DESC')->get();
//        return view('admin.panitia.resepsionis', compact('result'));
        $mhs = Mahasiswa::all();

        return DataTables::of($mhs)
            ->addcolumn('aksi',function ($mhs){
               return;
            })->make(true);

    }

    public function resepsionis()
    {
        return view('admin.panitia.resepsionis');

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

        if ($mahasiswa->status == 'A') {
            $mahasiswa->update([
                'login' => $request->login,
            ]);
            return back()->with('message', 'Akun Mahasiswa ' . $mahasiswa->id . ' berhasil diaktifkan');
        } else {
            return back()->with('message', 'Mahasiswa Berstatus Cuti / Non-aktir');
        }


    }

}
