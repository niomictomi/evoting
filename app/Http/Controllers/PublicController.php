<?php

namespace App\Http\Controllers;

use App\Jurusan;
use App\Mahasiswa;
use App\Pengaturan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PublicController extends Controller
{
    public function votingHmj(Request $request)
    {
        if (!Jurusan::checkByName($request->jurusan))
            return back()->withErrors([
                'Jurusan '.$request->jurusan.' tidak ada!',
                'Coba klik lagi menu yang anda inginkan'
            ]);
        $cek = Pengaturan::isVotingSedangBerlangsung() || Pengaturan::isVotingTelahBerlangsung();
        return view('admin.public.votinghmj', [
            'cek' => $cek,
            'jurusanobject' => Jurusan::findByName($request->jurusan),
            'jurusans' => Jurusan::all(),
            'jurusan' => $request->jurusan
        ]);
    }

    public function getDataPemilihHmj(Request $request)
    {
        $data = null;
        $jurusan = Jurusan::findByMd5Id($request->id);
        if ($request->status == md5('telah'))
            $data = Mahasiswa::getYangTelahMemilihHmjViaFlag($jurusan->id);
        elseif ($request->status == md5('belum'))
            $data = Mahasiswa::getYangBelumMemilihHmjViaFlag($jurusan->id);
        else
            $data = $jurusan->getMahasiswa()->where('status', 'A');

        return DataTables::of($data)->editColumn('prodi_id', function (Mahasiswa $mahasiswa){
            return $mahasiswa->getProdi()->nama;
        })->make(true);
    }
}
